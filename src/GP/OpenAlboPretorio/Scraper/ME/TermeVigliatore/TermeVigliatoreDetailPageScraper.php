<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore;

use GP\OpenAlboPretorio\Scraper\AbstractDetailPageScraper;
use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\HttpAdapter\HttpAdapterInterface;
use GP\OpenAlboPretorio\HttpAdapter\CurlHttpAdapter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TermeVigliatoreDetailPageScraper extends AbstractDetailPageScraper
{
    /**
     * @var HttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var Crawler
     */
    protected $scraper;

    /**
     * @var string
     */
    protected $prefixURL;

    /**
     * @param HttpAdapterInterface $httpClient
     */
    public function __construct(HttpAdapterInterface $httpClient = null)
    {
        $this->httpClient = (null === $httpClient) ? new CurlHttpAdapter() : $httpClient;
        $this->scraper = new Crawler();
    }

    /**
     * @inheritDoc
     */
    public function scrapeItemFrom($itemURL)
    {
        try {
            $itemHtml = $this->httpClient->getContent($itemURL);
        } catch (\Exception $e) {
            return null;
        }
        $this->setupPrefixURL($itemURL);
        $item = $this->extractItem($itemHtml);

        return $item;
    }

    // If the attachment links scraped are in relative URL format we have
    // to extract the prefix website URL in order to complete they
    private function setupPrefixURL($alboURL)
    {
        $parts = parse_url($alboURL);
        $this->prefixURL =  $parts['scheme']. '://' .
            $parts['host']  . ':' .
            $parts['port']  .
            substr($parts['path'], 0 ,14);
    }

    private function extractItem($itemHtml)
    {
        $this->scraper->addHtmlContent($itemHtml, 'UTF-8');

        $trs = $this->scraper->filter('td[class="bgsfondotab"] tr');

        $item = new AlboPretorioItem();

        foreach ($trs as $tr) {
            $this->scrapeTR($tr, $item);
        }

        $this->scraper->clear();

        return $item;
    }

    private function scrapeTR($tr, AlboPretorioItem $item)
    {
        $trText = trim($tr->nodeValue);

        if (preg_match('/Numero atto\/repertorio:(.*)/i', $trText, $matches) ) {
            $item->setNumeroAtto(trim($matches[1]));
        } elseif (preg_match('/Stato:(.*)/i', $trText, $matches)) {
            $item->setStato(trim($matches[1]));
        } elseif (preg_match('/Tipologia:(.*)/i', $trText, $matches)) {
            // At the beginning there are two strange characters  (ASCII :C2, A0)
            $tipologia = preg_replace('/[\xc2|\xa0]/','', $matches[1]);
            $item->setTipologia(trim($tipologia));
        } elseif (preg_match('/Descrizione:(.*)/i', $trText, $matches)) {
            $item->setDescrizione(trim($matches[1]));
        } elseif (preg_match('/Oggetto:(.*)/i', $trText, $matches)) {
            $item->setOggetto(trim($matches[1]));
        } elseif (preg_match('/Forma:(.*)/i', $trText, $matches)) {
            $item->setForma(trim($matches[1]));
        } elseif (preg_match('/Mittente:(.*)/i', $trText)) {

            $dateStr = substr($trText, -10);
            $dateTime = $this->getDateTimeFromStringDate($dateStr, '!d/m/Y');
            $item->setDataEmissione($dateTime);
        } elseif (preg_match('/Unit(.+) organizzativa responsabile:(.*)/ui', $trText, $matches)) {
            $item->setUnitaOrganizzativaResponsabile(trim($matches[2]));
        } elseif (preg_match('/Validit(.+) di pubblicazione:(.*)/ui', $trText, $matches)) {
            $dates = trim($matches[2]);
            if (preg_match('/dal\s(.*)\sal\s(.*)/', $dates, $matchesDate)) {

                $fromDate = trim($matchesDate[1]);
                $toDate = trim($matchesDate[2]);

                $dataTimeInizioPubblicazione = $this->getDateTimeFromStringDate($fromDate, '!d/m/Y');
                $dataTimeFinePubblicazione = $this->getDateTimeFromStringDate($toDate, '!d/m/Y');

                $item->setDataInizioPubblicazione($dataTimeInizioPubblicazione);
                $item->setDataFinePubblicazione($dataTimeFinePubblicazione);
            }
        } else {
            $this->scraper->clear();
            $this->scraper->addNode($tr);
            $anchors = $this->scraper->filter('td a')->each(
                function($node) {
                    return $node->attr('href');
                });
            if (! empty($anchors)) {
                $item->addAllegato($this->prefixURL . $this->urlEncodeTheLastPartOfTheURL($anchors[0]));
            }
        }
    }
}

<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG;

use GP\OpenAlboPretorio\HttpAdapter\CurlHttpAdapter;
use GP\OpenAlboPretorio\HttpAdapter\HttpAdapterInterface;
use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\Scraper\AbstractDetailPageScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGDetailPageScraper extends AbstractDetailPageScraper
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

        $item = $this->extractItem($itemHtml);

        return $item;
    }

    private function extractItem($itemHtml)
    {
        $this->scraper->addHtmlContent($itemHtml, 'UTF-8');
        $item = new AlboPretorioItem();

        $tds =  $this->scraper->filter('table.main_table table tr td')
            ->each(function($td) {
                return $td;
            });
        $this->scrapeTDs($tds, $item);
        $this->scraper->clear();

        return $item;

    }

    private function scrapeTDs($tds, $item)
    {
        $couplesTD = array_chunk($tds, 2);
        $couplesTD = $this->removeLastElementIfContainsSingleTD($couplesTD);

        foreach ($couplesTD as $coupleTD) {
            $tdLabel = trim($coupleTD[0]->text());
            $tdValue = trim($coupleTD[1]->text());

            switch ($tdLabel) {
                case 'anno':                $item->setAnno($tdValue); break;
                case 'pubblicazione n.':    $item->setNumeroPubblicazione($tdValue); break;
                case 'stato':               $item->setStato($tdValue); break;
                case 'importo':             $item->setImporto($tdValue); break;
                case 'capitolo':            $item->setCapitolo($tdValue); break;
                case 'annotazioni':         $item->setAnnotazioni($tdValue); break;
                case 'emessa da':           $item->setUnitaOrganizzativaResponsabile($tdValue); break;
                case 'tipo atto':           $item->setTipologia($tdValue); break;
                case 'numero atto':         $item->setNumeroAtto($tdValue); break;
                case 'oggetto':             $item->setOggetto($tdValue); break;
                case 'numero atto settore': $item->setNumeroAttoSettore($tdValue); break;
                case 'data pubblicazione':
                    if (null !== ($dateTime = $this->getDateTimeFromStringDate($tdValue, '!d-m-Y'))) {
                        $item->setDataInizioPubblicazione($dateTime);
                    }
                    break;
                case 'data emissione':
                    if (null !== ($dateTime = $this->getDateTimeFromStringDate($tdValue, '!d-m-Y'))) {
                        $item->setDataEmissione($dateTime);
                    }
                    break;
                case 'fine pubblicazione':
                    if (null !== ($dateTime = $this->getDateTimeFromStringDate($tdValue, '!d-m-Y'))) {
                        $item->setDataFinePubblicazione($dateTime);
                    }
                    break;
                case 'esecutiva da':
                    if (null !== ($dateTime = $this->getDateTimeFromStringDate($tdValue, '!d-m-Y'))) {
                        $item->setDataInizioEsecuzione($dateTime);
                    }
                    break;
                case 'copia atto':
                case 'Allegato Bando':
                    if (null !== ($allegato = $this->getAttachment($coupleTD[1]))) {
                        $item->addAllegato($allegato);
                    }
                    break;
                default:
                    if (false != mb_strstr($tdLabel, 'importo')) {
                        $item->setImporto($tdValue);
                    }
            }
        }
    }

    private function removeLastElementIfContainsSingleTD($couplesTD)
    {
        $lastKey = end(array_keys($couplesTD));
        if (0 != (count($couplesTD[$lastKey]) % 2)) {
            array_pop($couplesTD);
        }

        return $couplesTD;
    }

    private function getAttachment($td)
    {
        $hrefs = $td->filter('a')->extract(array('href'));

        // Removes blank elements
        $hrefs = array_filter($hrefs);

        if (! empty($hrefs)) {
            return $hrefs[0];
        }

        return null;
    }
}

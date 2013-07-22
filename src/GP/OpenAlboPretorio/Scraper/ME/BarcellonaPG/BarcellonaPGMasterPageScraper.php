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
use GP\OpenAlboPretorio\Scraper\MasterPageScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGMasterPageScraper implements MasterPageScraperInterface
{
    /**
     * @var Crawler
     */
    protected $scraper;

    /**
     * @var HttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $prefixURL;

    /**
     * Constructor
     *
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
    public function scrapeItemURLsFrom($alboURL)
    {
        $this->setupPrefixURL($alboURL);
        $alboHtml = $this->httpClient->getContent($alboURL);
        $itemURLs = $this->extractItemURLs($alboHtml);

        return $itemURLs;
    }

    // If the attachment links scraped are in relative URL format we have
    // to extract the prefix website URL in order to complete they
    private function setupPrefixURL($alboURL)
    {
        $parts = parse_url($alboURL);
        $this->prefixURL =  $parts['scheme']. '://' .
                            $parts['host']  .
                            substr($parts['path'], 0, 37) . '/';
    }

    private function extractItemURLs($alboHtml)
    {
        $this->scraper->addHtmlContent($alboHtml, 'UTF-8');
        $prefixURL = $this->prefixURL;
        $links =  $this->scraper->filter('a.onlyscreen')
                                ->each( function($a) use ($prefixURL) {
                                    $hrefs = $a->extract(array('href'));

                return $prefixURL . $hrefs[0];
            });

        $this->scraper->clear();

        return $links;

    }
}

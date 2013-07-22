<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper\ME\TermeVigliatore;

use GP\OpenAlboPretorio\HttpAdapter\CurlHttpAdapter;
use GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreMasterPageScraper;
use GP\OpenAlboPretorio\Tests\TestCase;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TermeVigliatoreMasterPageScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $http = new CurlHttpAdapter();
        $this->scraper = new TermeVigliatoreMasterPageScraper($http);
    }

    /**
     * @group scraper
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreMasterPageScraper', $this->scraper);
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetItemURLsFrom_ReturnsURLScraped()
    {
        $url = 'http://85.33.208.78:82/albopretorio/visualizza_atti_recenti.asp';
        $alboHtml = file_get_contents(__DIR__ . '/../../../Fixtures/master-page-termevigliatore.html');

        $adapter = m::mock('GP\OpenAlboPretorio\HttpAdapter\HttpAdapterInterface[getContent]');
        $adapter->shouldReceive('getContent')->with($url)->once()->andReturn($alboHtml);

        $extractor = new TermeVigliatoreMasterPageScraper($adapter);
        $expected = $this->getAlboPretorioItemURLs();
        $links = $extractor->scrapeItemURLsFrom($url);

        $this->assertInternalType('array', $links);
        $this->assertEquals($expected, $links);
    }

    /**
     * @group scraper
     * @group integration
     */
    public function testGetItemURLsFrom_WithRealURL()
    {
        $url = 'http://85.33.208.78:82/albopretorio/visualizza_atti_recenti.asp';

        $results = $this->scraper->scrapeItemURLsFrom($url);

        $this->assertInternalType('array', $results);
        $count = count($results);
        $this->assertGreaterThan(0, $count);
    }

    public function getAlboPretorioItemURLs()
    {
        return array(
            'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4137',
            'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4138',
            'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4139',
            'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4140'
        );
    }
}

<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper\ME\BarcellonaPG;

use GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGMasterPageScraper;
use GP\OpenAlboPretorio\Tests\TestCase;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGMasterPageScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $this->scraper = new BarcellonaPGMasterPageScraper();
    }

    /**
     * @group scraper
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGMasterPageScraper', $this->scraper);
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetItemURLsFrom_ReturnsURLScraped()
    {
        $url = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=&page=0&order=datapu&order_type=DESC&records_per_page=5';
        $alboHtml = file_get_contents(__DIR__ . '/../../../Fixtures/master-page-barcellonapg.html');

        $adapter = m::mock('GP\OpenAlboPretorio\HttpAdapter\HttpAdapterInterface[getContent]');
        $adapter->shouldReceive('getContent')->with($url)->once()->andReturn($alboHtml);

        $scraper = new BarcellonaPGMasterPageScraper($adapter);
        $expected = $this->getAlboPretorioItemURLs();
        $links = $scraper->scrapeItemURLsFrom($url);

        $this->assertInternalType('array', $links);
        $this->assertEquals($expected, $links);
    }

    /**
     * @group scraper
     * @group integration
     */
    public function testGetItemURLsFrom_ReturnsURLScrapedWithRealURL()
    {
        $url = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=&page=0&order=datapu&order_type=DESC&records_per_page=10';
        $results = $this->scraper->scrapeItemURLsFrom($url);
        $this->assertInternalType('array', $results);
        $count = count($results);
        $this->assertEquals(10, $count);
    }

    public function getAlboPretorioItemURLs()
    {
        return array(
            "http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=38626",
            "http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=38625",
            "http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=38632",
            "http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=38644",
            "http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=38637"
        );
    }
}

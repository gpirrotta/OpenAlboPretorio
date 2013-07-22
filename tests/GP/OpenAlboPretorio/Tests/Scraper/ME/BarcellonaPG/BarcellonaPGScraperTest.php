<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper\ME\TermeVigliatore;

use GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGDetailPageScraper;
use GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGMasterPageScraper;
use GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGScraper;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $this->scraper = new BarcellonaPGScraper(new BarcellonaPGMasterPageScraper(), new BarcellonaPGDetailPageScraper());
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorioUrl_ReturnsDefaultUrl()
    {
        $url = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=&page=0&order=datapu&order_type=DESC&records_per_page=10';
        $this->assertEquals($url, $this->scraper->buildAlboPretorioURL());
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorioUrl_ReturnsCustomUrlWhenItemTypeIsSet()
    {
        $url = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=%60atti%60.%60tipoatto%60+%3D+%27DETERMINAZIONE%20DEL%20SINDACO%27&page=0&order=datapu&order_type=DESC&records_per_page=10';
        $this->scraper->setItemType(BarcellonaPGScraper::TIPOLOGIA_DETERMINAZIONE_DEL_SINDACO);

        $this->assertEquals($url, $this->scraper->buildAlboPretorioURL());
    }
}

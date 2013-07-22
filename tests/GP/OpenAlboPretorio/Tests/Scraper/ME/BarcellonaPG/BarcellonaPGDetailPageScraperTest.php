<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper\ME\BarcellonaPG;

use GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGDetailPageScraper;
use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\Tests\TestCase;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGDetailPageScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $this->scraper = new BarcellonaPGDetailPageScraper();
    }

    /**
     * @group scraper
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGDetailPageScraper', $this->scraper);
    }

    /**
     * @group scraper
     * @group integration
     */
    public function testGetItemFrom_ReturnsAnItemCorrectlyExtracted()
    {
        $itemURL =  'file://' . __DIR__ . '/../../../Fixtures/detail-page-barcellonapg.html';
        $expected = $this->getAlboPretorioItem();

        $result = $this->scraper->scrapeItemFrom($itemURL);

        $this->assertInstanceOf('GP\OpenAlboPretorio\Model\AlboPretorioItem', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @group scraper
     * @group integration
     */
    public function testGetItemFrom_ReturnsAnItemCorrectlyExtractedWithRealURL()
    {
        $url = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=details&where_field=idatto&where_value=39139';
        $scraper = new BarcellonaPGDetailPageScraper();

        $item = $scraper->scrapeItemFrom($url);

        $this->assertInstanceOf('GP\OpenAlboPretorio\Model\AlboPretorioItem', $item);
        $this->assertNotNull($item->getAnno());
        $this->assertNotNull($item->getNumeroAtto());
        $this->assertNotNull($item->getOggetto());
    }

    public function getAlboPretorioItem()
    {
        $item = new AlboPretorioItem();
        $item->setAnno('2013');
        $item->setNumeroPubblicazione('2013-02969');
        $item->setDataInizioPubblicazione($this->createDateTimeFromStringDate('19/06/2013', '!d/m/Y'));
        $item->setUnitaOrganizzativaResponsabile('DIRETTORE SESTO SETTORE');
        $item->setTipologia('DETERMINAZIONE');
        $item->setNumeroAtto('2013-01955');
        $item->setDataEmissione($this->createDateTimeFromStringDate('19/06/2013', '!d/m/Y'));
        $item->setOggetto('IMPEGNO DI SPESA E VERSAMENTO PER RICHIESTA DI DEROGA IMPIANTO ANTINCENDIO NUOVO TEATRO MANDANICI');
        $item->setNumeroAttoSettore('2013-00460');
        $item->setDataFinePubblicazione($this->createDateTimeFromStringDate('04/07/2013', '!d/m/Y'));
        $item->setStato('IMMEDIATAMENTE ESECUTIVA');
        $item->setImporto('616,50');
        $item->setCapitolo('3000/04');
        $item->addAllegato('http://88.41.51.242/uploads/documento%20con%20spazi.pdf');
        $item->addAllegato('http://www.unime.it/allegato.pdf');

        return $item;
    }
}

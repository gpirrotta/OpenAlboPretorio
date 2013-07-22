<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper\ME\TermeVigliatore;

use GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreDetailPageScraper;
use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\Tests\TestCase;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TermeVigliatoreDetailPageScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $this->scraper = new TermeVigliatoreDetailPageScraper();
    }

    /**
     * @group scraper
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreDetailPageScraper', $this->scraper);
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetItemFrom_ReturnsAnItemCorrectlyExtracted()
    {
        $url = 'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4180';
        $itemHtml = file_get_contents(__DIR__ . '/../../../Fixtures/detail-page-termevigliatore.html');

        $adapter = m::mock('GP\OpenAlboPretorio\HttpAdapter\HttpAdapterInterface[getContent]');
        $adapter->shouldReceive('getContent')->with($url)->once()->andReturn($itemHtml);

        $scraper = new TermeVigliatoreDetailPageScraper($adapter);

        $expected = $this->getAlboPretorioItem();
        $result = $scraper->scrapeItemFrom($url);

        $this->assertInstanceOf('GP\OpenAlboPretorio\Model\AlboPretorioItem', $result);
        $this->assertEquals($expected, $result);
    }

    /**
     * @group scraper
     * @group integration
     */
    public function testGetItemFrom_ReturnsAnItemCorrectlyExtractedWithRealURL()
    {
        $url = 'http://85.33.208.78:82/albopretorio/visualizza_atto.asp?idatto=4180';

        $scraper = new TermeVigliatoreDetailPageScraper();
        $item = $scraper->scrapeItemFrom($url);

        $this->assertInstanceOf('GP\OpenAlboPretorio\Model\AlboPretorioItem', $item);
        $this->assertNotNull($item->getAnno());
        $this->assertNotNull($item->getNumeroAtto());
        $this->assertNotNull($item->getOggetto());

    }

    public function getAlboPretorioItem()
    {
        $item = new AlboPretorioItem();
        $item->setDataInizioPubblicazione($this->createDateTimeFromStringDate('28/06/2013', '!d/m/Y'));
        $item->setDataEmissione($this->createDateTimeFromStringDate('28/06/2013', '!d/m/Y'));
        $item->setUnitaOrganizzativaResponsabile('Area Tecnica - Anagrafe - Stato Civile');
        $item->setTipologia('Pubblicazioni di Matrimonio');
        $item->setNumeroAtto('00004137');
        $item->setForma('Integrale');
        $item->setOggetto('Pubblicazione di matrimonio Minnie e Topolino');
        $item->setDescrizione('Pubblicazione di matrimonio Minnie/Topolino');
        $item->setDataFinePubblicazione($this->createDateTimeFromStringDate('10/07/2013', '!d/m/Y'));
        $item->setStato('In corso di pubblicazione');
        $item->addAllegato('http://85.33.208.78:82/albopretorio/public/4814_Pubblicazione%20di%20matrimonio%20Minnie_Topolino.pdf');

        return $item;
    }
}

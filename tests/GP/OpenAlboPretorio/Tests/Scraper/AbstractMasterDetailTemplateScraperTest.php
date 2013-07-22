<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper;

use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\Model\AlboPretorioBag;
use GP\OpenAlboPretorio\Tests\TestCase;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AbstractMasterDetailTemplateScraperTest extends TestCase
{
    private $detail;
    private $master;
    private $scraper;

    public function setUp()
    {
        $this->master = m::mock('GP\OpenAlboPretorio\Scraper\MasterPageScraperInterface[scrapeItemURLsFrom]');
        $this->detail = m::mock('GP\OpenAlboPretorio\Scraper\DetailPageScraperInterface[scrapeItemFrom]');
        $this->scraper = m::mock('GP\OpenAlboPretorio\Scraper\AbstractMasterDetailTemplateScraper[buildAlboPretorioURL]', array($this->master, $this->detail));
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorio_ReturnsABagOfItems()
    {
        $alboURL = 'http://AlboPretorioURL.it';

        $itemURLs = array('http://linkOfAlboPretorio.it/atto1.html', 'http://linkOfAlboPretorio.it/atto2.html');

        $item1 = new AlboPretorioItem();
        $item1->setNumeroAtto('1');
        $item1->setOggetto('determina 1');

        $item2 = new AlboPretorioItem();
        $item2->setNumeroAtto('2');
        $item2->setOggetto('determina 2');

        $bagExpected = new AlboPretorioBag();
        $bagExpected->addItem($item1);
        $bagExpected->addItem($item2);
        $bagExpected->setLink($alboURL);

        $this->scraper->shouldReceive('buildAlboPretorioURL')->once()->andReturn($alboURL);
        $this->master->shouldReceive('scrapeItemURLsFrom')->with($alboURL)->once()->andReturn($itemURLs);

        // found 2 item URLs - start loop
        $this->detail->shouldReceive('scrapeItemFrom')->with($itemURLs[0])->once()->andReturn($item1);
        $this->detail->shouldReceive('scrapeItemFrom')->with($itemURLs[1])->once()->andReturn($item2);

        $bagResult = $this->scraper->scrapeAlboPretorio();

        $this->assertEquals($bagExpected, $bagResult);
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorio_ReturnsAMessageErrorIfAlboURLIsWrong()
    {
        $url = 'httdp://www.wrongURL.com';
        $errorMessage = 'Errore URL Albo Pretorio';
        $this->scraper->shouldReceive('buildAlboPretorioURL')->once()->andReturn($url);
        $this->master->shouldReceive('scrapeItemURLsFrom')->with($url)->once()->andThrow('\Exception', $errorMessage);
        $bag = $this->scraper->scrapeAlboPretorio();

        $this->assertNotNull($bag->getErrorMessage());
        $this->assertEquals($errorMessage, $bag->getErrorMessage());
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorio_ReturnsItemsOnlyForItemUrlsNotWrong()
    {
        $alboURL = 'http://AlboPretorioURL.it';

        // the second URL is wrong so no Item is extracted and added to the bag
        $itemURLs = array('http://linkOfAlboPretorio.it/atto1.html', 'http://linkOfAlboPretorio.it/LINKERROR');

        $item1 = new AlboPretorioItem();
        $item1->setNumeroAtto('1');
        $item1->setOggetto('determina 1');

        $bagExpected = new AlboPretorioBag();
        $bagExpected->addItem($item1);
        $bagExpected->setLink($alboURL);

        $this->scraper->shouldReceive('buildAlboPretorioURL')->once()->andReturn($alboURL);
        $this->master->shouldReceive('scrapeItemURLsFrom')->with($alboURL)->once()->andReturn($itemURLs);

        // found 2 item URLs - start loop
        $this->detail->shouldReceive('scrapeItemFrom')->with($itemURLs[0])->once()->andReturn($item1);
        $this->detail->shouldReceive('scrapeItemFrom')->with($itemURLs[1])->once()->andReturn(null);

        $bagResult = $this->scraper->scrapeAlboPretorio();

        $this->assertEquals($bagExpected, $bagResult);
    }
}

<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests;

use GP\OpenAlboPretorio\Formatter\FeedFormatter;
use GP\OpenAlboPretorio\OpenAlboPretorio;
use GP\OpenAlboPretorio\Scraper\AlboPretorioScraperFactory;
use GP\OpenAlboPretorio\Model\AlboPretorioBag;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class OpenAlboPretorioTest extends TestCase
{
    private $openAlboPretorio;
    private $scraper;
    private $formatter;
    private $factory;

    public function setUp()
    {
        $this->scraper = m::mock('GP\OpenAlboPretorio\Scraper\AlboPretorioScraperInterface[scrapeAlboPretorio]');
        $this->formatter = m::mock('GP\OpenAlboPretorio\Formatter\FormatterInterface[format]');
        $this->factory = m::mock('GP\OpenAlboPretorio\Scraper\AlboPretorioScraperFactoryInterface[build]');
        $this->openAlboPretorio = new OpenAlboPretorio($this->factory, $this->formatter);
    }

    /**
     * @group open
     * @group unit
     */
    public function testOpen()
    {
        $returnBag = new AlboPretorioBag();
        $this->scraper->shouldReceive('scrapeAlboPretorio')->once()->andReturn($returnBag);
        $this->formatter->shouldReceive('format')->with($returnBag)->once()->andReturn($returnBag);
        $this->factory->shouldReceive('build')->with(AlboPretorioScraperFactory::TERME_VIGLIATORE)->once()->andReturn($this->scraper);
        $this->openAlboPretorio->city(AlboPretorioScraperFactory::TERME_VIGLIATORE);
        $this->openAlboPretorio->open();
    }

    /**
     * @group open
     * @group acceptance
     */
    public function testOpen_ReturnsJsonResultWithRealAlboURL()
    {
        $albo = new OpenAlboPretorio();
        $albo->city(AlboPretorioScraperFactory::BARCELLONA_POZZO_DI_GOTTO);
        $albo->maxNumberItems(1);
        $results =  $albo->open();

        $json = json_decode($results);
        $this->assertTrue(is_object($json));
    }

    /**
     * @group open
     * @group acceptance
     */
    public function testOpen_ReturnsFeedXMLTypeRSSWithRealAlboLink()
    {
        $albo = new OpenAlboPretorio(null, new FeedFormatter());

        $albo->city(AlboPretorioScraperFactory::BARCELLONA_POZZO_DI_GOTTO);
        $albo->maxNumberItems(1);
        $feed =  $albo->open();
        $this->assertTrue(FALSE !== simplexml_load_string($feed));
    }

    /**
     * @group open
     * @group unit
     * @expectedException \Exception
     * @expectedExceptionMessage Set the city to scrape or the scraper to use
     */
    public function testOpen_ThrowsAnExceptionIfCityOrScraperIsNotSet()
    {
        $albo = new OpenAlboPretorio();
        $feed =  $albo->open();
    }
}

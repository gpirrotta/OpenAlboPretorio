<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper;

use GP\OpenAlboPretorio\Scraper\AlboPretorioScraperFactory;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AlboPretorioScraperFactoryTest extends TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new AlboPretorioScraperFactory();
    }

    /**
     * @group factory
     * @group unit
     */
    public function testBuild_CheckIfTheClassIsFound()
    {
        $termeVigliatoreScraper = $this->factory->build(AlboPretorioScraperFactory::TERME_VIGLIATORE);
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreScraper', $termeVigliatoreScraper);

        $barcellonaPGScraper = $this->factory->build(AlboPretorioScraperFactory::BARCELLONA_POZZO_DI_GOTTO);
        $this->assertInstanceOf('GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPGScraper', $barcellonaPGScraper);
    }

    /**
     * @group factory
     * @group unit
     * @expectedException \Exception
     * @expectedExceptionMessage Scraper class not found
     */
    public function testBuild_ThrowsAnExceptionIfClassNotExist()
    {
        $termeVigliatoreScraper = $this->factory->build('Class not existing');
    }
}

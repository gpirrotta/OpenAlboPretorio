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
use GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreMasterPageScraper;
use GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatoreScraper;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TermeVigliatoreScraperTest extends TestCase
{
    private $scraper;

    public function setUp()
    {
        $this->scraper = new TermeVigliatoreScraper(new TermeVigliatoreMasterPageScraper(), new TermeVigliatoreDetailPageScraper());
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorioUrl_ReturnsDefaultUrl()
    {
        $url = 'http://85.33.208.78:82/albopretorio/ricerca_atti.asp';
        $this->assertEquals($url, $this->scraper->buildAlboPretorioURL());
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testGetAlboPretorioUrl_ReturnsCustomUrlWhenItemTypeIsSet()
    {
        $this->scraper->setItemType(TermeVigliatoreScraper::TIPOLOGIA_DETERMINE_DIRIGENZIALI);

        $url = 'http://85.33.208.78:82/albopretorio/ricerca_atti.asp&Tipologia=8';

        $this->assertEquals($url, $this->scraper->buildAlboPretorioURL());
    }
}

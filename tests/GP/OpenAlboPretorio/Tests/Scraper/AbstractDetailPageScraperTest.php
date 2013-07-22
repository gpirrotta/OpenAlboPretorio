<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Scraper;

use GP\OpenAlboPretorio\Scraper\AbstractDetailPageScraper;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AbstractDetailPageScraperTest extends TestCase
{
    /**
     * @group unit
     * @dataProvider datesProvider
     */
    public function testGetTimestampFromStringDate($dateStr, $format, $expected)
    {
        $scraper = new DetailScraperMock();

        $timestamp = $scraper->getDateTimeFromStringDate($dateStr, $format);

        $this->assertEquals($expected, $timestamp);
    }

    public function datesProvider()
    {
        // With ! in the format the function resets all fields
        //(year, month, day, hour, minute, second, fraction and timezone information) to the Unix Epoch
        return array(
            array('01/01/2010','!d/m/Y', $this->createDateTimeFromStringDate('01/01/2010','!d/m/Y')),
            array('13/11-2013','!d/m-Y', $this->createDateTimeFromStringDate('13/11-2013','!d/m-Y')),
            array('13/03-2000','!d/m/Y', null),
            array('13/13/20a10','!d/m/Y', null),
            array('19-06-2013', '!d-m-Y', $this->createDateTimeFromStringDate('19-06-2013','!d-m-Y')),
            array('19-16-2013', '!d-m-Y', null),
            array('09-a12-2013', '!d-m-Y', null)
        );
    }

    /**
     * @group scraper
     * @group unit
     */
    public function testUrlEncode_ReturnsTheLastPartOfUrlEncoded()
    {
        $linkAttachment = 'http://www.example.foo/documento con spazi.pdf';
        $scraper = new DetailScraperMock();

        $result = $scraper->urlEncodeTheLastPartOfTheURL($linkAttachment);

        $expected = 'http://www.example.foo/documento%20con%20spazi.pdf';
        $this->assertEquals($expected, $result);

    }

}

class DetailScraperMock extends AbstractDetailPageScraper
{
    public function scrapeItemFrom($itemURL) {}
}

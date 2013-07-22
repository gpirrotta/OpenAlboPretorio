<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Model;

use GP\OpenAlboPretorio\Model\AlboPretorioItem;
use GP\OpenAlboPretorio\OpenAlboPretorio;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AlboPretorioItemTest extends TestCase
{
    private $item;

    public function setUp()
    {
        $this->item = new AlboPretorioItem();
    }

    /**
     * @group model
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Model\AlboPretorioItem', $this->item);
    }

    /**
     * @group model
     * @group unit
     * @dataProvider datesProvider
     */
    public function testGetFormattedInizioPublicazione($date, $format, $expected)
    {
        $this->assertEquals('', $this->item->getFormattedDataInizioPubblicazione($format));

        $this->item->setDataInizioPubblicazione($date);
        $formatted = $this->item->getFormattedDataInizioPubblicazione($format);

        $this->assertEquals($expected, $formatted);
    }

    /**
     * @group model
     * @group unit
     * @dataProvider datesProvider
     */
    public function testGetFormattedDataFinePublicazione($date, $format, $expected)
    {
        $this->assertEquals('', $this->item->getFormattedDataFinePubblicazione($format));

        $this->item->setDataFinePubblicazione($date);
        $formatted = $this->item->getFormattedDataFinePubblicazione($format);

        $this->assertEquals($expected, $formatted);
    }

    /**
     * @group model
     * @group unit
     * @dataProvider datesProvider
     */
    public function testGetFormattedDataEmissione($date, $format, $expected)
    {
        $this->assertEquals('', $this->item->getFormattedDataEmissione($format));

        $this->item->setDataEmissione($date);
        $formatted = $this->item->getFormattedDataEmissione($format);

        $this->assertEquals($expected, $formatted);
    }

    /**
     * @group model
     * @group unit
     * @dataProvider datesProvider
     */

    public function testGetFormattedDataInizioEsecuzione($date, $format, $expected)
    {
        $this->assertEquals('', $this->item->getFormattedDataInizioEsecuzione($format));

        $this->item->setDataInizioEsecuzione($date);
        $formatted = $this->item->getFormattedDataInizioEsecuzione($format);

        $this->assertEquals($expected, $formatted);
    }

    public function datesProvider()
    {
        return array(
            array($this->createDateTimeFromStringDate('01/01/2010', '!d/m/Y'), 'd/m/Y', '01/01/2010'),
            array($this->createDateTimeFromStringDate('13/11-2013', '!d/m-Y'), 'd/m-Y', '13/11-2013')
        );
    }
}

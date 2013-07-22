<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Formatter;

use GP\OpenAlboPretorio\Formatter\FeedFormatter;
use GP\OpenAlboPretorio\Model\AlboPretorioBag;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class FeedFormatterTest extends TestCase
{
    /**
     * @group formatter
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $formatter = new FeedFormatter();
        $this->assertInstanceOf('GP\OpenAlboPretorio\Formatter\FeedFormatter', $formatter);
    }

    /**
     * @group formatter
     * @group integration
     */
    public function testFormat_ReturnsAnXMLFeedRSSType()
    {
        $formatter = new FeedFormatter('rss');
        $bag = $this->getAlboPretorioBag();

        $feed = $formatter->format($bag);

        $this->assertTrue(FALSE !== simplexml_load_string($feed));
        $this->assertContains('rss', $feed);
    }

    /**
     * @group formatter
     * @group integration
     */
    public function testFormat_ReturnsAnXMLFeedAtomType()
    {
        $formatter = new FeedFormatter('atom');
        $bag = $this->getAlboPretorioBag();

        $feed = $formatter->format($bag);

        $this->assertTrue(FALSE !== simplexml_load_string($feed));
        $this->assertContains('atom', $feed);
        $this->assertNotContains('rss', $feed);
    }

    /**
     * @group formatter
     * @group integration
     */
    public function testFormat_ReturnsAFeedErrorIfSomethingDoesntWork()
    {
        $bag = new AlboPretorioBag();
        $formatter = new FeedFormatter();
        $bag->setErrorMessage('Error Message');
        $bag->setLink('http://albopretorio.it');

        $feed = $formatter->format($bag);

        $this->assertTrue(FALSE !== simplexml_load_string($feed));
        $this->assertContains('Error Message', $feed);
    }

    /**
     * @group formatter
     * @group unit
     * @expectedException \Exception
     * @expectedExceptionMessage Type feed error
     */
    public function testConstructor_IfReceivesAnErrorFeedTypeThrowsAnException()
    {
        $type = 'rss-type-wrong';
        $formatter = new FeedFormatter($type);
    }
}

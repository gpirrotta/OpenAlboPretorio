<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace Geocoder\Tests\HttpAdapter;

use GP\OpenAlboPretorio\HttpAdapter\CurlHttpAdapter;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class CurlHttpAdapterTest extends TestCase
{
    protected $adapter;

    protected function setUp()
    {
        if (!function_exists('curl_init')) {
            $this->markTestSkipped('cURL has to be enabled.');
        }

        $this->adapter = new CurlHttpAdapter();
    }

    /**
     * @group http
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\HttpAdapter\CurlHttpAdapter', $this->adapter);
    }

    /**
     * @group http
     * @group integration
     */
    public function testGetContent_ReturnsTheHtmlContent()
    {
        $html = $this->adapter->getContent('http://www.google.com');
        $this->assertContains('google', $html);
    }

    /**
     * @group http
     * @group unit
     * @expectedException \Exception
     */
    public function testGetContent_ThrowsAnExceptionWithURLNull()
    {
        $this->assertNull($this->adapter->getContent(null));
    }

    /**
     * @group http
     * @group unit
     * @expectedException \Exception
     */
    public function testGetContent_ThrowsAnExceptionWithURLFalse()
    {
        $this->assertNull($this->adapter->getContent(false));
    }

    /**
     * @group http
     * @group integration
     * @expectedException \Exception
     */
    public function testGetContent_ThrowsAnExceptionWithURLWrong()
    {
        $this->assertNull($this->adapter->getContent('http2://I.am.a.wrong.URL'));
    }
}

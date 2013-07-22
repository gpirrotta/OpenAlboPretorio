<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\HttpAdapter;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
interface HttpAdapterInterface
{
    /**
     * Get the HTML content of the URL specified in the parameter
     *
     * @param  string $url
     * @return string The content of the URL
     */
    public function getContent($url);
}

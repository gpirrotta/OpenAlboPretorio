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
class CurlHttpAdapter implements HttpAdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getContent($url)
    {
        if (("" === $url) || (null === $url)) {
            throw new \Exception('Url not valid');
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        $content = curl_exec($c);
        curl_close($c);

        if (false === $content) {
            throw new \Exception(sprintf('Problem opening page %s', $url));
        }

        return $content;
    }
}

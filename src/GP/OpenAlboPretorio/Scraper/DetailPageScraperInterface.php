<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
interface DetailPageScraperInterface
{
    /**
     * Scrapes the item website
     *
     * @param string $itemURL
     *
     * @return AlboPretorioItem
     */
    public function scrapeItemFrom($itemURL);
}

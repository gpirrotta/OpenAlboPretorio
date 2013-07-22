<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Formatter;

use GP\OpenAlboPretorio\Model\AlboPretorioBag;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
interface FormatterInterface
{
    /**
     * Formats items
     *
     * @param AlboPretorioBag $bag
     *
     * @return string
     */
    public function format(AlboPretorioBag $bag);
}

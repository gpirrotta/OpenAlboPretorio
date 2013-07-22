<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Formatter;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * Set the error message
     *
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the error message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}

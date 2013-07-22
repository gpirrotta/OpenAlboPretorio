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
abstract class AbstractDetailPageScraper implements DetailPageScraperInterface
{
    /**
     * Create a \DateTime object starting from the string date and the format specified
     *
     * @param $stringDate
     * @param string $format
     *
     * @return \DateTime|null
     */
    public function getDateTimeFromStringDate($stringDate, $format = '!d/m/Y')
    {
        $timezone = new \DateTimeZone('UTC');
        $dateTime = \DateTime::createFromFormat($format, $stringDate, $timezone);
        $errors = \DateTime::getLastErrors();

        $isValid = ((0 == $errors['warning_count']) && (0 == $errors['error_count']));

        return $isValid ? $dateTime : null;
    }

    /**
     * Urlencode the last part of the URL (starting from the last /)
     *
     * @param $url
     *
     * @return string
     */
    public function urlEncodeTheLastPartOfTheURL($url)
    {
        $parts = explode('/', $url);
        $lastKey = end(array_keys($parts));
        $lastPart = rawurlencode($parts[$lastKey]);
        $parts[$lastKey] = $lastPart;

        return implode('/', $parts);
    }
}

<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio;

use GP\OpenAlboPretorio\Scraper\AlboPretorioScraperFactory;
use GP\OpenAlboPretorio\Scraper\AlboPretorioScraperFactoryInterface;
use GP\OpenAlboPretorio\Scraper\AlboPretorioScraperInterface;
use GP\OpenAlboPretorio\Formatter\FormatterInterface;
use GP\OpenAlboPretorio\Formatter\JSONFormatter;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class OpenAlboPretorio implements OpenAlboPretorioInterface
{
    /**
     *@const integer Default max results
     */
    const MAX_NUMBER_ITEMS = 5;

    /**
     * @var AlboPretorioScraperInterface
     */
    protected $scraper = null;

    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @var AlboPretorioScraperFactoryInterface
     */
    protected $factory;

    /**
     * @var int
     */
    protected $maxNumberItems;

    /**
     * Constructor
     *
     * @param AlboPretorioScraperFactoryInterface $factory
     * @param FormatterInterface                  $formatter
     * @param integer                             $maxNumberItems
     */
    public function __construct(AlboPretorioScraperFactoryInterface $factory = null, FormatterInterface $formatter = null, $maxNumberItems = self::MAX_NUMBER_ITEMS)
    {
        $this->setResultFactory($factory);
        $this->formatUsing($formatter);
        $this->maxNumberItems($maxNumberItems);
    }

    /**
     * @inheritDoc
     */
    public function open()
    {
        if (null === $this->scraper) {
            throw new \Exception('Set the city to scrape or the scraper to use');
        }

        $bag = $this->scraper->scrapeAlboPretorio($this->maxNumberItems);

        $result = $this->formatter->format($bag);

        return $result;
    }

    /**
     * @param AlboPretorioScraperFactoryInterface $factory
     */
    public function setResultFactory(AlboPretorioScraperFactoryInterface $factory = null)
    {
        $this->factory = $factory ?: new AlboPretorioScraperFactory();
    }

    /**
     * Set the max items to find
     *
     * @param integer $maxNumberItems
     */
    public function maxNumberItems($maxNumberItems)
    {
        $this->maxNumberItems = $maxNumberItems;

        return $this;
    }

    /**
     * @return integer $maxNumberItems
     */
    public function getMaxNumberItems()
    {
        return $this->maxNumberItems;
    }

    /**
     * @param FormatterInterface $formatter
     */
    public function formatUsing(FormatterInterface $formatter = null)
    {
        $this->formatter = $formatter ?: new JSONFormatter();

        return $this;
    }

    /**
     * @param $city
     */
    public function city($city)
    {
        $this->scraper =  $this->factory->build($city);

        return $this;
    }

    /**
     * @param AlboPretorioScraperInterface $scraper
     */
    public function scrapeUsing(AlboPretorioScraperInterface $scraper)
    {
        $this->scraper = $scraper;

        return $this;
    }
}

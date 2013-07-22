<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper;

use GP\OpenAlboPretorio\Model\AlboPretorioBag;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
abstract class AbstractMasterDetailTemplateScraper implements AlboPretorioScraperInterface
{
    /**
     * @var MasterPageScraperInterface
     */
    protected $master;

    /**
     * @var DetailPageScraperInterface
     */
    protected $detail;

    /**
     * @var string
     */
    protected $itemType;

    /**
     * Constructor
     *
     * @param MasterPageScraperInterface $master
     * @param DetailPageScraperInterface  =
     */
    public function __construct(MasterPageScraperInterface $master, DetailPageScraperInterface $detail)
    {
        $this->master = $master;
        $this->detail = $detail;
    }

    /**
     * @inheritDoc
     */
    public function scrapeAlboPretorio($maxNumberItems = null)
    {
        $alboURL = $this->buildAlboPretorioURL();
        $bag = new AlboPretorioBag();

        //Extracts item URLs from MASTER Albo Page
        try {
            $itemURLs = $this->master->scrapeItemURLsFrom($alboURL);
        } catch (\Exception $e) {
            $bag->setErrorMessage($e->getMessage());

            return $bag;
        }

        $bag->setLink($alboURL);
        $this->setupMaxNumberItems($maxNumberItems, $itemURLs);

        // Extracts DETAIL from item pages
        foreach (array_slice($itemURLs, 0, $this->maxNumberItems) as $itemURL) {
            $item = $this->detail->scrapeItemFrom($itemURL);
            if (null !== $item) {
                $item->setLink($itemURL);
                $bag->addItem($item);
            }
        }

        return $bag;
    }

    private function setupMaxNumberItems($maxNumberItems, array $itemURLs)
    {
        $numberItems = count($itemURLs);
        $this->maxNumberItems =  ((null !== $maxNumberItems) && ($maxNumberItems < $numberItems)) ? $maxNumberItems : $numberItems;
    }

    /**
     * @param string $itemType
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
    }

    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @return string Returns the Albo Pretorio start Web page URL
     */
    abstract public function buildAlboPretorioURL();
}

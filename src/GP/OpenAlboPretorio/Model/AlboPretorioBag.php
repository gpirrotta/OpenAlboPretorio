<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Model;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AlboPretorioBag
{
    /**
     * @var AlboPretorioItem[]
     */
    protected $items = array();

    /**
     * @var string The URL of the albo pretorio
     */
    //TODO: to refactor in URL
    protected $link;

    /**
     * @var string
     */
    protected $errorMessage = null;

    /**
     * Add an item into bag
     *
     * @param AlboPretorioItem
     */
    public function addItem(AlboPretorioItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param AlboPretorioItem[]
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return AlboPretorioItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param string
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}

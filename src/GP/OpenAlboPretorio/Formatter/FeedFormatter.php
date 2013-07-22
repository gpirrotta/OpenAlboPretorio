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
use GP\OpenAlboPretorio\Model\AlboPretorioItem;

use Zend\Feed\Writer\Feed;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class FeedFormatter extends AbstractFormatter
{
    /**
     *@const string
     */
    const  RSS_FEED_TYPE  = 'rss';

    /**
     *@const string
     */
    const  ATOM_FEED_TYPE = 'atom';

    /**
     * @var Feed
     */
    protected $feed;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @var string
     */
    protected $dateFormat;

    /**
     * Constructor
     *
     * @param string $type
     * @param Feed   $feed
     */
    public function __construct($type = null, Feed $feed = null)
    {
        $this->feed        = (null === $feed) ? new Feed() : $feed;
        $this->title       = 'Open Albo Pretorio';
        $this->description = 'Open Albo Pretorio';
        $this->setupType($type);
        $this->dateUpdated = time();
        $this->id = null;
        $this->author = array();
        $this->errorMessage = null;
    }

    /**
     * Returns all items formatted as a RSS|ATOM feed
     *
     * @inheritDoc
     */
    public function format(AlboPretorioBag $bag)
    {
        $link = $bag->getLink();
        $this->feed->setEncoding('UTF-8');
        $this->feed->setLink($link);
        $this->feed->setDescription($this->description);
        $this->feed->setFeedLink($bag->getLink(), $this->type);
        //TODO: Improve mechanism to manage feed update removing time() function
        $this->feed->setDateModified(time());
        $this->id = (null !== $this->id) ?: $link;
        $this->feed->setId($this->id);
        $error = $bag->getErrorMessage();

        if (null === $error) {
            $this->feed->setTitle($this->title);
            $this->makeFeedEntries($bag->getItems());
        } else {
            $this->feed->setTitle($error);
        }

        return $this->feed->export($this->type);
    }

    /**
     * Set the id feed
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the id feed
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the title feed
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set the title feed
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the description of the feed
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the description of the feed
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the author's name, email and uri
     *
     * @param string $name
     * @param string $email
     * @param string $uri
     */
    public function setAuthor($name, $email = null, $uri = null)
    {
        $author = array();
        $author['name'] = $name;

        if (null != $email) {
            $author['email'] = $email;
        }

        if (null != $uri) {
            $author['uri'] = $uri;
        }

        $this->feed->addAuthor($author);
    }

    /**
     * Return the author info
     *
     * @return array
     */
    public function getAuthor()
    {
        return $this->author;
    }

    private function setupType($type)
    {
        if ((null !== $type) &&
            (self::RSS_FEED_TYPE  !== $type) &&
            (self::ATOM_FEED_TYPE !== $type))
        {
            throw new \Exception('Type feed error');
        }

        if ((null === $type) || (self::RSS_FEED_TYPE === $type)) {
            $this->type = self::RSS_FEED_TYPE;
            $this->dateFormat = \DateTime::RSS;
        } else {
            $this->type = self::ATOM_FEED_TYPE;
            $this->dateFormat = \DateTime::ATOM;
        }
    }

    private function makeFeedEntries(array $items)
    {
        foreach ($items as $item) {
            $entry = $this->feed->createEntry();
            $entry->setLink($item->getLink());
            $entry->setTitle($item->getOggetto());

            $entry->setDateModified($item->getDataInizioPubblicazione());
            $content = $this->makeFeedContent($item);
            $entry->setContent($content);

            $this->feed->addEntry($entry);
        }
    }

    private function makeFeedContent(AlboPretorioItem $item)
    {
        //TODO: to improve
        $content = sprintf('<p><b>Anno:</b> %s </p>', $item->getAnno());
        $content .= sprintf('<p><b>Descrizione:</b> %s </p> ', $item->getDescrizione());
        $content .= sprintf('<p><b>Data inizio pubblicazione:</b> %s </p> ', $item->getFormattedDataInizioPubblicazione($this->dateFormat));
        $content .= sprintf('<p><b>Data fine pubblicazione:</b> %s </p> ', $item->getFormattedDataFinePubblicazione($this->dateFormat));
        $content .= sprintf('<p><b>Data inizio esecuzione:</b> %s </p> ', $item->getFormattedDataInizioEsecuzione($this->dateFormat));
        $content .= sprintf('<p><b>Data emissione:</b> %s </p> ', $item->getFormattedDataEmissione($this->dateFormat));
        $content .= sprintf('<p><b>Capitolo:</b> %s </p> ', $item->getCapitolo());
        $content .= sprintf('<p><b>Tipologia:</b> %s </p> ', $item->getTipologia());
        $content .= sprintf('<p><b>Stato:</b> %s </p> ', $item->getStato());
        $content .= sprintf('<p><b>Forma:</b> %s </p> ', $item->getForma());
        $content .= sprintf('<p><b>Numero atto:</b> %s </p> ', $item->getNumeroAtto());
        $content .= sprintf('<p><b>Numero atto settore:</b> %s </p> ', $item->getNumeroAttoSettore());
        $content .= sprintf('<p><b>Unità organizzativa responsabile:</b> %s </p> ', $item->getUnitaOrganizzativaResponsabile());
        $content .= sprintf('<p><b>Importo:</b> %s </p> ', $item->getImporto());

        $content .= $this->makeFeedContentAllegati($item->getAllegati());
        $content .= sprintf('<p><b>Annotazioni:</b> %s </p> ', $item->getAnnotazioni());

        return $content;
    }

    private function makeFeedContentAllegati(array $attachments)
    {
        $content = '';
        foreach ($attachments as $attachment) {
            $content .= sprintf('<p><b>Allegato:</b> <a href="%s">%s</a></p>', $attachment, $attachment);
        }

        return $content;
    }
}

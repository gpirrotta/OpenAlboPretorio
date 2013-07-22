<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests;

use GP\OpenAlboPretorio\Model\AlboPretorioBag;
use GP\OpenAlboPretorio\Model\AlboPretorioItem;

use \Mockery as m;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $stringDate
     * @param $format
     * @return \DateTime
     */
    public function createDateTimeFromStringDate($stringDate, $format)
    {
        $timezone = new \DateTimeZone('UTC');

        return \DateTime::createFromFormat($format, $stringDate, $timezone);
    }

    /**
     * @return AlboPretorioBag
     */
    public function getAlboPretorioBag()
    {

        $bag = new AlboPretorioBag();
        $bag->setLink('http://albopretorio.it');

        $item = new AlboPretorioItem();
        $item->setLink('http://www.albopretorio.it/attoamministrativo/numero/1');
        $item->setAnno('2013');
        $item->setNumeroPubblicazione('2013-02969');

        $item->setDataInizioPubblicazione($this->createDateTimeFromStringDate('19/06/2013', '!d/m/Y'));
        $item->setDataFinePubblicazione($this->createDateTimeFromStringDate('04/07/2013', '!d/m/Y'));
        $item->setDataEmissione($this->createDateTimeFromStringDate('19/06/2013', '!d/m/Y'));
        $item->setDataInizioEsecuzione($this->createDateTimeFromStringDate('25/06/2013', '!d/m/Y'));

        $item->setUnitaOrganizzativaResponsabile('DIRETTORE SESTO SETTORE');
        $item->setTipologia('DETERMINAZIONE');
        $item->setNumeroAtto('2013-01955');
        $item->setOggetto('IMPEGNO DI SPESA E VERSAMENTO PER RICHIESTA');
        $item->setNumeroAttoSettore('2013-00460');
        $item->setStato('IMMEDIATAMENTE ESECUTIVA');
        $item->setImporto('616,50');
        $item->setCapitolo('3000/04');
        $item->setAnnotazioni('ANNOTAZIONI');

        $item->addAllegato('http://albopretorio.it/allegato.pdf');
        $item->addAllegato('http://albopretorio.it/allegato2.docx');

        $bag->addItem($item);
        $bag->addItem($item);

        return $bag;
    }

    public function tearDown()
    {
        m::close();
    }
}

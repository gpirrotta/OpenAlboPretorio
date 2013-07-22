<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Tests\Formatter;

use GP\OpenAlboPretorio\Model\AlboPretorioBag;
use GP\OpenAlboPretorio\Formatter\JSONFormatter;
use GP\OpenAlboPretorio\Tests\TestCase;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class JSONFormatterTest extends TestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new JSONFormatter();
    }

    /**
     * @group formatter
     * @group unit
     */
    public function test_CanCreateIt()
    {
        $this->assertInstanceOf('GP\OpenAlboPretorio\Formatter\JSONFormatter', $this->formatter);
    }

    /**
     * @group formatter
     * @group integration
     */
    public function testFormat_ReturnsTheItemJSONized()
    {
        $bag = $this->getAlboPretorioBag();

        $json = $this->formatter->format($bag);

        $this->assertEquals($this->jsonResult(), $json);
    }

    /**
     * @group formatter
     * @group unit
     */
    public function testFormat_ReturnsAJSONErrorIfSomethingDoesntWork()
    {
        $albo = new AlboPretorioBag();
        $albo->setErrorMessage('Error Message');

        $json = $this->formatter->format($albo);

        $jsonExpected = <<<JSON
{
    "errorMessage": "Error Message"
}
JSON;
        $this->assertEquals($jsonExpected, $json);
    }

    public function jsonResult()
    {
        $json = <<<JSON
{
    "title": "OpenAlboPretorio project",
    "link": "http://albopretorio.it",
    "atti": [
        {
            "link": "http://www.albopretorio.it/attoamministrativo/numero/1",
            "anno": "2013",
            "numeroAtto": "2013-01955",
            "numeroPubblicazione": "2013-02969",
            "dataEmissione": "19/06/2013",
            "dataInizioPubblicazione": "19/06/2013",
            "dataFinePubblicazione": "04/07/2013",
            "dataInizioEsecuzione": "25/06/2013",
            "unitaOrganizzativaResponsabile": "DIRETTORE SESTO SETTORE",
            "attoTipologia": "DETERMINAZIONE",
            "oggetto": "IMPEGNO DI SPESA E VERSAMENTO PER RICHIESTA",
            "descrizione": "",
            "numeroAttoSettore": "2013-00460",
            "stato": "IMMEDIATAMENTE ESECUTIVA",
            "forma": "",
            "importo": "616,50",
            "capitolo": "3000/04",
            "annotazioni": "ANNOTAZIONI",
            "allegati": [
                "http://albopretorio.it/allegato.pdf",
                "http://albopretorio.it/allegato2.docx"
            ]
        },
        {
            "link": "http://www.albopretorio.it/attoamministrativo/numero/1",
            "anno": "2013",
            "numeroAtto": "2013-01955",
            "numeroPubblicazione": "2013-02969",
            "dataEmissione": "19/06/2013",
            "dataInizioPubblicazione": "19/06/2013",
            "dataFinePubblicazione": "04/07/2013",
            "dataInizioEsecuzione": "25/06/2013",
            "unitaOrganizzativaResponsabile": "DIRETTORE SESTO SETTORE",
            "attoTipologia": "DETERMINAZIONE",
            "oggetto": "IMPEGNO DI SPESA E VERSAMENTO PER RICHIESTA",
            "descrizione": "",
            "numeroAttoSettore": "2013-00460",
            "stato": "IMMEDIATAMENTE ESECUTIVA",
            "forma": "",
            "importo": "616,50",
            "capitolo": "3000/04",
            "annotazioni": "ANNOTAZIONI",
            "allegati": [
                "http://albopretorio.it/allegato.pdf",
                "http://albopretorio.it/allegato2.docx"
            ]
        }
    ]
}
JSON;

        return $json;
    }
}

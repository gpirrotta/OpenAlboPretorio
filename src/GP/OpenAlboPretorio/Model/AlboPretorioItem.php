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
class AlboPretorioItem
{
    /**
     * @var string
     */
    protected $anno = '';

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $tipologia = '';

    /**
     * @var string
     */
    protected $numeroAtto = '';

    /**
     * @var string
     */
    protected $numeroPubblicazione = '';

    /**
     * @var string
     */
    protected $numeroAttoSettore = '';

    /**
     * @var \DateTime
     */
    protected $dataInizioPubblicazione = null;

    /**
     * @var \DateTime
     */
    protected $dataFinePubblicazione = null;

    /**
     * @var \Datetime
     */
    protected $dataEmissione = null;

    /**
     * @var \DateTime
     */
    protected $dataInizioEsecuzione = null;

    /**
     * @var string
     */
    protected $unitaOrganizzativaResponsabile = '';

    /**
     * @var string
     */
    protected $oggetto = '';

    /**
     * @var string
     */
    protected $descrizione = '';

    /**
     * @var string
     */
    protected $stato = '';

    /**
     * @var string
     */
    protected $forma = '';

    /**
     * @var string
     */
    protected $importo = '';

    /**
     * @var string
     */
    protected $capitolo = '';

    /**
     * @var string
     */
    protected $annotazioni = '';

    /**
     * @var string[] Urls
     */
    protected $allegati = array();

    /**
     * @param string $allegato
     */
    public function addAllegato($allegato)
    {
        $this->allegati[] = $allegato;
    }

    /**
     * @param string[] $allegati
     */
    public function setAllegati($allegati)
    {
        $this->allegati = $allegati;
    }

    /**
     * @return string[]
     */
    public function getAllegati()
    {
        return $this->allegati;
    }

    /**
     * @param string $anno
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;
    }

    /**
     * @return string
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * @param string $annotazioni
     */
    public function setAnnotazioni($annotazioni)
    {
        $this->annotazioni = $annotazioni;
    }

    /**
     * @return string
     */
    public function getAnnotazioni()
    {
        return $this->annotazioni;
    }

    /**
     * @param string $capitolo
     */
    public function setCapitolo($capitolo)
    {
        $this->capitolo = $capitolo;
    }

    /**
     * @return string
     */
    public function getCapitolo()
    {
        return $this->capitolo;
    }

    /**
     * @param \DateTime $dataEmissione
     */
    public function setDataEmissione(\DateTime $dataEmissione)
    {
        $this->dataEmissione = $dataEmissione;
    }

    /**
     * @return \DateTime
     */
    public function getDataEmissione()
    {
        return $this->dataEmissione;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getFormattedDataEmissione($format)
    {
        return $this->getFormattedDate($this->dataEmissione, $format);
    }

    /**
     * @param \DateTime $dataFinePubblicazione
     */
    public function setDataFinePubblicazione(\DateTime $dataFinePubblicazione)
    {
        $this->dataFinePubblicazione = $dataFinePubblicazione;
    }

    /**
     * @return \DateTime
     */
    public function getDataFinePubblicazione()
    {
        return $this->dataFinePubblicazione;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getFormattedDataFinePubblicazione($format)
    {
        return $this->getFormattedDate($this->dataFinePubblicazione, $format);
    }

    /**
     * @param \DateTime $dataInizioEsecuzione
     */
    public function setDataInizioEsecuzione(\DateTime $dataInizioEsecuzione)
    {
        $this->dataInizioEsecuzione = $dataInizioEsecuzione;
    }

    /**
     * @return \DateTime
     */
    public function getDataInizioEsecuzione()
    {
        return $this->dataInizioEsecuzione;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getFormattedDataInizioEsecuzione($format)
    {
        return $this->getFormattedDate($this->dataInizioEsecuzione, $format);
    }

    /**
     * @param \DateTime $dataInizioPubblicazione
     */
    public function setDataInizioPubblicazione(\DateTime $dataInizioPubblicazione)
    {
        $this->dataInizioPubblicazione = $dataInizioPubblicazione;
    }

    /**
     * @return \DateTime
     */
    public function getDataInizioPubblicazione()
    {
        return $this->dataInizioPubblicazione;
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function getFormattedDataInizioPubblicazione($format)
    {
       return $this->getFormattedDate($this->dataInizioPubblicazione, $format);
    }

    /**
     * @param \DateTime $date
     * @param string    $format
     *
     * @return string
     */
    private function getFormattedDate($date, $format)
    {
        if (null != $date) {
            return $date->format($format);
        }

        return '';
    }

    /**
     * @param string $importo
     */
    public function setImporto($importo)
    {
        $this->importo = $importo;
    }

    /**
     * @return string
     */
    public function getImporto()
    {
        return $this->importo;
    }

    /**
     * @param string $link
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
     * @param string $numeroAtto
     */
    public function setNumeroAtto($numeroAtto)
    {
        $this->numeroAtto = $numeroAtto;
    }

    /**
     * @return string
     */
    public function getNumeroAtto()
    {
        return $this->numeroAtto;
    }

    /**
     * @param string $numeroAttoSettore
     */
    public function setNumeroAttoSettore($numeroAttoSettore)
    {
        $this->numeroAttoSettore = $numeroAttoSettore;
    }

    /**
     * @return string
     */
    public function getNumeroAttoSettore()
    {
        return $this->numeroAttoSettore;
    }

    /**
     * @param string $numeroPubblicazione
     */
    public function setNumeroPubblicazione($numeroPubblicazione)
    {
        $this->numeroPubblicazione = $numeroPubblicazione;
    }

    /**
     * @return string
     */
    public function getNumeroPubblicazione()
    {
        return $this->numeroPubblicazione;
    }

    /**
     * @param string $oggetto
     */
    public function setOggetto($oggetto)
    {
        $this->oggetto = $oggetto;
    }

    /**
     * @return string
     */
    public function getOggetto()
    {
        return $this->oggetto;
    }

    /**
     * @param string $stato
     */
    public function setStato($stato)
    {
        $this->stato = $stato;
    }

    /**
     * @return string
     */
    public function getStato()
    {
        return $this->stato;
    }

    /**
     * @param string $tipologia
     */
    public function setTipologia($tipologia)
    {
        $this->tipologia = $tipologia;
    }

    /**
     * @return string
     */
    public function getTipologia()
    {
        return $this->tipologia;
    }

    /**
     * @param string $unitaOrganizzativaResponsabile
     */
    public function setUnitaOrganizzativaResponsabile($unitaOrganizzativaResponsabile)
    {
        $this->unitaOrganizzativaResponsabile = $unitaOrganizzativaResponsabile;
    }

    /**
     * @return string
     */
    public function getUnitaOrganizzativaResponsabile()
    {
        return $this->unitaOrganizzativaResponsabile;
    }

    /**
     * @param string $descrizione
     */
    public function setDescrizione($descrizione)
    {
        $this->descrizione = $descrizione;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->descrizione;
    }

    /**
     * @param string $forma
     */
    public function setForma($forma)
    {
        $this->forma = $forma;
    }

    /**
     * @return string
     */
    public function getForma()
    {
        return $this->forma;
    }
}

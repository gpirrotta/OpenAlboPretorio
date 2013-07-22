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

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class JSONFormatter extends AbstractFormatter
{
    /**
     * Returns items in json format
     *
     * @inheritDoc
     */
    public function format(AlboPretorioBag $bag)
    {
        $error = $bag->getErrorMessage();

        if (null !== $error) {
            $message = array('errorMessage' => $error);

            //TODO: add 5.3 compatibility
            return  json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }

        $itemsArray = array();

        foreach ($bag->getItems() as $item) {
            $itemsArray[] = $this->fromItemToArray($item);
        }

        $bagArray = array('title' => 'OpenAlboPretorio project',
                           'link' => $bag->getLink());
        $bagArray['atti'] = $itemsArray;

        //TODO: add 5.3 compatibility
        return json_encode($bagArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private function fromItemToArray(AlboPretorioItem $item)
    {
        $itemsArray = array(
            'link'                           => $item->getLink(),
            'anno'                           => $item->getAnno(),
            'numeroAtto'                     => $item->getNumeroAtto(),
            'numeroPubblicazione'            => $item->getNumeroPubblicazione(),
            'dataEmissione'                  => $item->getFormattedDataEmissione('d/m/Y'),
            'dataInizioPubblicazione'        => $item->getFormattedDataInizioPubblicazione('d/m/Y'),
            'dataFinePubblicazione'          => $item->getFormattedDataFinePubblicazione('d/m/Y'),
            'dataInizioEsecuzione'           => $item->getFormattedDataInizioEsecuzione('d/m/Y'),
            'unitaOrganizzativaResponsabile' => $item->getUnitaOrganizzativaResponsabile(),
            'attoTipologia'                  => $item->getTipologia(),
            'oggetto'                        => $item->getOggetto(),
            'descrizione'                    => $item->getDescrizione(),
            'numeroAttoSettore'              => $item->getNumeroAttoSettore(),
            'stato'                          => $item->getStato(),
            'forma'                          => $item->getForma(),
            'importo'                        => $item->getImporto(),
            'capitolo'                       => $item->getCapitolo(),
            'annotazioni'                    => $item->getAnnotazioni());

        $allegati = $item->getAllegati();

        if (! empty($allegati)) {
            $itemsArray['allegati'] = $allegati;
        }

        return $itemsArray;
    }
}

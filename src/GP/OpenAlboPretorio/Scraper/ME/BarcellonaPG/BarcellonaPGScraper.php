<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG;

use GP\OpenAlboPretorio\Scraper\AbstractMasterDetailTemplateScraper;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class BarcellonaPGScraper extends AbstractMasterDetailTemplateScraper
{

    const ALBO_PRETORIO_BASE_URL = 'http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=%s&page=0&order=datapu&order_type=DESC&records_per_page=10';

    const TIPOLOGIA_ATTI_DI_INTERESSE_GENERALE              = "ATTI DI INTERESSE GENERALE";
    const TIPOLOGIA_PUBBLICATI_SU_RICHIESTA_DI_ENTI         = "ATTI PUBBLICATI SU RICHIESTA DI ENTI";
    const TIPOLOGIA_AVVISI_DEPOSITO_ATTI                    = "AVVISI DEPOSITO ATTI";
    const TIPOLOGIA_AVVISI_DEPOSITO_CARTELLE_ESATTORIALI    = "AVVISI DEPOSITO CARTELLE ESATTORIALI";
    const TIPOLOGIA_BANDI_AVVISI_DI_GARA                    = "BANDI - AVVISI DI GARA";
    const TIPOLOGIA_CONCESSIONI_EDILIZIE                    = "CONCESSIONI EDILIZIE";
    const TIPOLOGIA_CONCORSI                                = "CONCORSI";
    const TIPOLOGIA_DELIBERA                                = "DELIBERA";
    const TIPOLOGIA_DETERMINAZIONE                          = "DETERMINAZIONE";
    const TIPOLOGIA_DETERMINAZIONE_DEL_SINDACO              = "DETERMINAZIONE DEL SINDACO";
    const TIPOLOGIA_LISTE_ELETTORALI                        = "LISTE ELETTORALI";
    const TIPOLOGIA_MANIFESTI                               = "MANIFESTI";
    const TIPOLOGIA_ORDINANZA                               = "ORDINANZA";
    const TIPOLOGIA_ORDINANZA_DEL_SINDACO                   = "ORDINANZA DEL SINDACO";
    const TIPOLOGIA_PROGRAMMI_ELETTORALI                    = "PROGRAMMI ELETTORALI";
    const TIPOLOGIA_PUBBLICAZIONI_MATRIMONIO                = "PUBBLICAZIONI MATRIMONIO";
    const TIPOLOGIA_REVISIONE_LISTE_ELETTORALI              = "REVISIONE LISTE ELETTORALI";
    const TIPOLOGIA_VERBALI_RISULTANZE_DI_GARA              = "VERBALI RISULTANZE DI GARA";

    /**
     * @var string
     */
    protected $url = BarcellonaPGScraper::ALBO_PRETORIO_BASE_URL;

    /**
     * @inheritDoc
     */
    public function buildAlboPretorioURL()
    {
        return (null === $this->itemType) ?
               sprintf($this->url, '') :
               sprintf($this->url,"%60atti%60.%60tipoatto%60+%3D+%27". rawurlencode($this->itemType) . "%27");
    }
}

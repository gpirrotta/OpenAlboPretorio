<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore;

use GP\OpenAlboPretorio\Scraper\AbstractMasterDetailTemplateScraper;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class TermeVigliatoreScraper extends AbstractMasterDetailTemplateScraper
{

    const ALBO_PRETORIO_BASE_URL = 'http://85.33.208.78:82/albopretorio/ricerca_atti.asp';

    const TIPOLOGIA_ACCERTAMENTI                                = 57;
    const TIPOLOGIA_ALBI_COMUNALI                               = 14;
    const TIPOLOGIA_ATTI_DI_PIGNORAMENTO                        = 48;
    const TIPOLOGIA_AVVISI                                      = 15;
    const TIPOLOGIA_AVVISI_GARE_DI_APPALTO                      = 21;
    const TIPOLOGIA_BANDI                                       =  1;
    const TIPOLOGIA_BOLLETTINI                                  = 42;
    const TIPOLOGIA_CALENDARI_REPERIBILITA                      = 20;
    const TIPOLOGIA_CANCELLAZIONI                               = 58;
    const TIPOLOGIA_COMUNICAZIONI                               = 54;
    const TIPOLOGIA_CONCESSIONI                                 = 27;
    const TIPOLOGIA_CONCESSIONI_EDILIZIE_CON_CONTRIBUTO         = 41;
    const TIPOLOGIA_CONCESSIONI_EDILIZIE_IN_SANATORIA           = 24;
    const TIPOLOGIA_CONVOCAZIONI_ASSEMBLEE                      = 33;
    const TIPOLOGIA_CONVOCAZIONI_CONSIGLIO_COMUNALE             = 11;
    const TIPOLOGIA_DECRETI                                     = 50;
    const TIPOLOGIA_DECRETI_DI_CONCESSIONE                      = 25;
    const TIPOLOGIA_DELIBERE                                    = 52;
    const TIPOLOGIA_DELIBERE_DI_CONSIGLIO                       =  4;
    const TIPOLOGIA_DELIBERE_DI_GIUNTA                          =  5;
    const TIPOLOGIA_DETERMINAZIONI                              = 47;
    const TIPOLOGIA_DETERMINE_DIRIGENZIALI                      =  8;
    const TIPOLOGIA_DETERMINE_SINDACALI                         = 10;
    const TIPOLOGIA_ELENCHI                                     = 31;
    const TIPOLOGIA_ELENCHI_DI_CUI_AL_COMMA_7_ART_7_LEGGE_47_85 = 18;
    const TIPOLOGIA_GRADUATORIE                                 = 22;
    const TIPOLOGIA_INGIUNZIONI                                 = 44;
    const TIPOLOGIA_INTEGRAZIONI_ORDINE_DEL_GIORNO              = 51;
    const TIPOLOGIA_INTIMAZIONI                                 = 53;
    const TIPOLOGIA_ISTANZE                                     = 45;
    const TIPOLOGIA_LICENZE_COMMERCIALI                         =  6;
    const TIPOLOGIA_LISTE                                       = 29;
    const TIPOLOGIA_MANIFESTI                                   = 35;
    const TIPOLOGIA_NOTIFICHE_AI_SENSI_ART_60_DPR               = 26;
    const TIPOLOGIA_NOTIFICHE_AI_SENSI_ART_60_LETT_E_DPR_600_73 = 56;
    const TIPOLOGIA_NOTIFICHE_AI_SENSI_ART_140                  = 38;
    const TIPOLOGIA_NOTIFICHE_AI_SENSI_ART_143                  = 19;
    const TIPOLOGIA_ORDINANZE                                   = 39;
    const TIPOLOGIA_ORDINANZE_POLIZIA_MUNICIPALE                =  3;
    const TIPOLOGIA_ORDINANZE_SINDACALI                         =  9;
    const TIPOLOGIA_PIANI_TURNO                                 = 61;
    const TIPOLOGIA_PROGETTI                                    = 40;
    const TIPOLOGIA_PROGRAMMI                                   = 60;
    const TIPOLOGIA_PROVVEDIMENTI                               = 32;
    const TIPOLOGIA_PUBBLICAZIONI_DI_MATRIMONIO                 =  7;
    const TIPOLOGIA_RELAZIONI                                   = 55;
    const TIPOLOGIA_RENDICONTI                                  = 46;
    const TIPOLOGIA_REVISIONI                                   = 30;
    const TIPOLOGIA_RICHIESTE_CONCESSIONI                       = 28;
    const TIPOLOGIA_RISULTATI_ELEZIONI                          = 62;
    const TIPOLOGIA_SCHEMI                                      = 34;
    const TIPOLOGIA_SENTENZE                                    = 49;
    const TIPOLOGIA_TRASMISSIONI                                = 43;
    const TIPOLOGIA_VERBALI                                     = 36;
    const TIPOLOGIA_VERBALI_DI_GARA                             = 23;
    const TIPOLOGIA_VERIFICHE                                   = 59;

    /**
     * @var string
     */
    protected $url = self::ALBO_PRETORIO_BASE_URL;

    /**
     * @inheritDoc
     */
    public function buildAlboPretorioURL()
    {
        return (null === $this->itemType) ? $this->url : $this->url . '&Tipologia=' . $this->itemType;
    }
}

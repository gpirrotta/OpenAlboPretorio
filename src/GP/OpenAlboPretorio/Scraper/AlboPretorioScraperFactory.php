<?php

/**
 * This file is part of the OpenAlboPretorio package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace GP\OpenAlboPretorio\Scraper;

use GP\OpenAlboPretorio\Scraper;

/**
 * @author Giovanni Pirrotta <giovanni.pirrotta@gmail.com>
 */
class AlboPretorioScraperFactory implements AlboPretorioScraperFactoryInterface
{
    const TERME_VIGLIATORE          = 1;
    const BARCELLONA_POZZO_DI_GOTTO = 2;

    private $mapper = array( 1 => 'GP\OpenAlboPretorio\Scraper\ME\TermeVigliatore\TermeVigliatore',
                             2 => 'GP\OpenAlboPretorio\Scraper\ME\BarcellonaPG\BarcellonaPG');

    /**
     * @param string $city The city identification for the class to build
     *
     * @return AlboPretorioScraperInterface
     *
     * @throws \Exception If a id city does not exist
     */
    final public function build($city)
    {
        if (! array_key_exists($city, $this->mapper)) {
            throw new \Exception('Scraper class not found');
        }

        $class  = $this->mapper[$city] . 'Scraper';
        $master = $this->mapper[$city] . 'MasterPageScraper';
        $detail = $this->mapper[$city] . 'DetailPageScraper';

        return new $class(new $master, new $detail);

    }

}

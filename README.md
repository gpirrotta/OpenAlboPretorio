OpenAlboPretorio
=========

The **OpenAlboPretorio** project consists in a scraper library able to extract data from
the **Albo Pretorio** Web archive present on Italian city institutional websites. The
**Albo Pretorio** is the public archive containing all administrative acts that concern the
Municipality administrive life.
Extracted data can be exported in JSON (default) and Feed (rss2, atom) formats.

[![Build Status](https://travis-ci.org/gpirrotta/OpenAlboPretorio.png?branch=master)](https://travis-ci.org/gpirrotta/OpenAlboPretorio)

Installation
------------

Clone the github repo in your machine

``` bash
$ git clone https://github.com/gpirrotta/OpenAlboPretorio.git
$ cd OpenAlboPretorio
```

And run these two commands to install it:

``` bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
```

Now you can add the autoloader, and you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

You're done.

## Usage
The `OpenAlboPretorio` class is the entry point of the library.

``` php
<?php

    $albo = new OpenAlboPretorio();
    $results = $albo->city(AlboPretorioScraperFactory::TERME_VIGLIATORE);
                    ->open();

    print $results  // JSON format as default
```

You can also customize the scraper manually:

``` php
<?php

    $scraper = new BarcellonaPGScraper(new BarcellonaPGMasterPageScraper(), new BarcellonaPGDetailPageScraper());
    // you can also customize the Master and Detail scraper objects using i.e. different HttpAdapter objects

    $scraper->setItemType(BarcellonaPGScraper::TIPOLOGIA_DETERMINAZIONE_DEL_SINDACO);
    $formatter = new FeedFormatter(FeedFormatter::ATOM_FEED_TYPE);  // RSS2 default

    $albo = new OpenAlboPretorio();
    $results = $albo->scrapeUsing($scraper)
                    ->formatUsing($formatter)
                    ->maxNumberItems(10)
                    ->open();

    print $results;
```


### The OpenAlboPretorio API

* `city($city)`: set the city to scrape. The `$city` parameter is the `id` city of the Web page to scrape.

 Examples:
 ``` php
 <?php

  $albo->city(AlboPretorioScraperFactory::TERME_VIGLIATORE);
 ```

Alternatively to the `city` method you can set your customized scraper using

* `scrapeUsing(AlboPretorioScraperInterface $scraper)` method.

You can customized the scraped results with:

* `maxNumberItems($maxNumberItems)`:  set the maximum number of items to scrape;

* `formatUsing(FormatterInterface $formatter)`: set the output format. The default is JSON format
but you can choose also the Feed (rss2, atom) format;

* `open()`: it starts the game returning the scraped data.

### Scraper
Currently the following scrapers are implemented:

* `TermeVigliatoreScraper` (Scrapes data from [Terme Vigliatore (ME)](http://85.33.208.78:82/albopretorio/ricerca_atti.asp))
* `BarcellonaPGScraper` (Scrapes data from [Barcellona Pozzo di Gotto (ME)](http://88.41.51.242/gesdelidet/dadabik_4.2/program_files/index.php?table_name=atti&function=search&where_clause=&page=0&order=datapu&order_type=DESC&records_per_page=50)

### Formatter
Formatters available:

* `JSONFormatter`: (default) formats the scraped results in JSON format;
* `FeedFormatter($type)`: formats the scraped results in Feed format; type parameter can be one of these:

    * `FeedFormatter::RSS_FEED_TYPE` (default)
    * `FeedFormatter::ATOM_FEED_TYPE`

###Extending the OpenAlboPretorio project
If you want to extend the **Albo Pretorio** project for your city you have to implement the `AlboPretorioScraperInterface` interface.

Generally scraping an `Albo Pretorio` Web page means extract data from two pages:

1) the `Master page` -  the Web page containing the list of all Albo Pretorio items, i.e. all administrative acts
 of the Municipality, where you can find the summary of the last item published including the URL of each item;

2) the `Detail page` -  the single Web page item where you can find the detail of each administrative act.

To manage correctly the above described scraping logic the `OpenAlboPretorio` library provides the 
`AbstractMasterDetailTemplateScraper` abstract class implementing the `AlboPretorioScraperInterface` interface.

The abstract class uses the following scraper interfaces:

 * `MasterPageScraperInterface` - retrieves the list of item URLs to scrape;
 * `DetailPageScraperInterface` - retrieves the detail of each single administrative act, i.e. an item. - it must return an `AlboPretorioItem` class

Obviously if the extraction logic of your Albo Pretorio Web page is different from the `Master-Detail` you are free to implement the one that meets your needs.

## Requirements

- >= PHP 5.4

## Running the Tests

``` bash
$ phpunit
```

## Demo

* Albo Pretorio Terme Vigliatore [JSON](http://www.pirrotta.it/webapps/openalbopretorio/index.php/termevigliatore.json) [RSS2](http://www.pirrotta.it/webapps/openalbopretorio/index.php/termevigliatore.rss) [ATOM](http://www.pirrotta.it/webapps/openalbopretorio/index.php/termevigliatore.atom)
* Albo Pretorio Barcellona Pozzo di Gotto [JSON](http://www.pirrotta.it/webapps/openalbopretorio/index.php/barcellonapg.json) [RSS2](http://www.pirrotta.it/webapps/openalbopretorio/index.php/barcellonapg.rss) [ATOM](http://www.pirrotta.it/webapps/openalbopretorio/index.php/barcellonapg.atom)

## TODO

* Improve test coverage
* Add scrapers
* Add formatters

## Credits

* Giovanni Pirrotta <giovanni.pirrotta@gmail.com>

## License

OpenAlboPretorio is released under the MIT License. See the bundled LICENSE file for
details.




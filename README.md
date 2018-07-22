# Rayne\Pagination

Pagination library without dependencies.

## Contents

* [Installation](#installation)
* [Features](#features)
* [Usage](#usage)
* [Examples](#examples)
* [Tests](#tests)

## Installation

It's recommended to use the dependency manager
[Composer](https://getcomposer.org/download)
to install `rayne/pagination`.

```bash
composer require rayne/pagination
```

## Features

* Implementation of the
  [Search Pagination Pattern](https://web.archive.org/web/20160407044536/https://developer.yahoo.com/ypatterns/navigation/pagination/search.html)
  defined by Yahoo

  * One or zero indexed pages

  * Extracts safe page numbers from arbitrary user inputs,
    e.g. first or last page on invalid input or when being out of bounds

* Implementation of the
  [Filter Pagination Pattern](https://web.archive.org/web/20150905182227/https://developer.yahoo.com/ypatterns/navigation/alphafilterlinks.html)
  defined by Yahoo

  (This pattern is currently not officially supported but the code is ready for playing around)

* No dependencies (except the ones for testing)

* Framework-agnostic

  * No markup (but Bootstrap examples in `/examples`)

  * No template engine (but Twig examples in `/examples`)

  * No database backend (but offset and limit provided)

  * No URL builder

## Usage

### SearchPagination

1. Retrieve item count `$totalItems`

2. Let `Rayne\Pagination` calculate the offset

   ```php
   $pagination = new SearchPagination(
       $totalItems,
       $itemsPerPage,
       $currentPage,
       $pagePadding = 4, 
       $isZeroBased = false
   );
   ```

3. Verify `$currentPage` with `$pagination->isOnValidPage()`
   or retrieve the requested items with the help of `$pagination->getItemOffset()`
   and `$pagination->getItemLimit()`

4. Render results and controls with the help of `$pagination`
   or `$pagination->toArray()`
   and the example templates in the `/examples` directory

Read the [Examples](#examples) section for examples and ideas.

### SearchPaginationFactory

Instead of creating the `SearchPaginationInterface` implementation by hand
a configurable factory can be used to provide the pagination as a service.

1. Either create a new factory (useful when working with a DI system) …

   ```php
   $factory = new SearchPaginationFactory;
   ```

   … or initialize/fetch the global one

   ```php
   $factory = SearchPaginationFactory::instance();
   ```

   The defaults are: one-indexed pages, `20` items per page and a page padding of `4`.

2. Configure the factory (or skip this step)

   ```php
   $factory->setIsZeroBased(true);
   $factory->setItemsPerPage(25);
   $factory->setPagePadding(2);
   ```

3. Build a new `SearchPagination` object

   ```php
   $totalItems = 123;
   $currentPage = 2;
   $pagination = $factory->build($totalItems, $currentPage);
   ```

### FilterPagination

The filter pagination pattern is not officially supported
but feel free to play around with the following classes:

```php
Rayne\Pagination\Filter\FilterPage
Rayne\Pagination\Filter\FilterPages
Rayne\Pagination\Filter\FilterPagination
```

## Examples

The following examples are part of the `/examples` directory.

* Complete example (`/examples/index.php`)

* Simple (highlights current page) and advanced (highlights current page, hides redundant pagination controls) examples

  * PHP snippets (`/examples/PHP`)

  * [Twig](http://twig.sensiolabs.org) macros (`/examples/Twig`)

* The Twig macros are [Bootstrap Framework](http://getbootstrap.com) compatible

## Tests

1. Clone the repository

   ```bash
   git clone https://github.com/rayne/pagination.git
   ```

2. Install the development dependencies

   ```bash
   composer install --dev
   ```

3. Run the tests

   ```bash
   composer test
   ```

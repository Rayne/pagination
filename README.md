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

* Implementation of the *Search Pagination Pattern* defined by
  [Yahoo (Dead Link)](https://developer.yahoo.com/ypatterns/navigation/pagination/search.html)

* Implementation of the *Filter Pagination Pattern* defined by Yahoo
  (This pattern is currently not officially supported but the code is ready for playing around)

* No dependencies (except the ones for testing)

* Support for zero indexed pages (`$isZeroBased=true`)

* Safe page verification accepting `mixed` data (client's raw input)

* Ignore invalid page requests with `!SearchPagination->isOnValidPage()`

* Fetch appropriate offsets (for first or last page) on special pages

  * Pages out of bounds (`-10` or `900` out of `10`)

  * Invalid pages (`4x`, `3.41` or `ARRAY()`  aren't integers)

* No markup

* Decoupled from databases

* Array export for templating (`toArray()`)

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
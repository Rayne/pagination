Rayne\Pagination
================

Pagination library without dependencies.

FEATURES
--------

*	No dependencies (except the ones for testing)
*	Support for zero indexed pages (`$isZeroBased=true`)
*	Safe page verification accepting `mixed` data (client's raw input)
*	Ignore invalid page requests with `!SearchPagination->isOnValidPage()`
*	Fetch appropriate offsets (for first or last page) on special pages
	*	Pages out of bounds (`-10` or `900` out of `10`)
	*	Invalid pages (`4x`, `3.41` or `ARRAY()`  aren't integers)
*	No markup
*	Decoupled from databases
*	Array export for templating (`toArray()`)

INSTALLATION
------------

It is recommended to install the library with [Composer](https://getcomposer.org).

INSTALLATION WITH COMPOSER
--------------------------

	php -r "readfile('https://getcomposer.org/installer');" | php
	php composer.phar require --update-no-dev Rayne/Pagination

MANUAL INSTALLATION
-------------------

1.	Download the latest package from [GitHub](https://github.com/rayne/pagination)
1.	Extract the package
1.	Register the library with one of the following options
	*	Point a PSR-4 loader with `Rayne\Pagination` to `PACKAGE/src/Rayne/Pagination`
	*	`require_once PACKAGE/bootstrap.php;` (without dependencies)

EXAMPLES
--------

The following examples are part of the `/examples` directory.

*	Working HTML/PHP example (`/examples/index.php`)
*	Simple (highlights current page) and advanced (highlights current page, hides redundant pagination controls) examples
	*	PHP snippets (`/examples/PHP`)
	*	[Twig](http://twig.sensiolabs.org) macros (`/examples/Twig`)
*	The Twig macros are [Bootstrap Framework](http://getbootstrap.com) compatible

USAGE
-----

1.	Retrieve item count `$totalItems`
1.	Let `Rayne\Pagination` calculate the offset

		$pagination = new SearchPaginationImpl(
			$totalItems, $itemsPerPage, $currentPage, $pagePadding = 4, $isZeroBased = false);

1.	Verify `$currentPage` with `$pagination->isOnValidPage()`
	or retrieve the requested items with the help of `$pagination->getItemOffset()` and `$pagination->getItemLimit()`
1.	Render results and controls with the help of `$pagination` or `$pagination->toArray()`

Read the [EXAMPLES](#EXAMPLES) section for examples and ideas.

REPACKING
---------

You are allowed to repack the library for shipping with your projects.
The following files and directories are required.

*	`src/Rayne/Pagination`
*	`bootstrap.php` (not required when using a PSR4-loader or Composer)

You are not allowed to remove licencing agreements.

TESTS
-----

	composer install --dev
	vendor/bin/phpunit

LICENCE
-------

TODO
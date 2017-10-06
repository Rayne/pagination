<?php

use Rayne\Pagination\SearchPagination;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * The sophisticated database for this example.
 */
$database = range(1, 128);

/**
 * @var $requestedPage string|int Avoid integer casting, as it is ambiguous (for instance "4x" == int(4)).
 * @var $padding int Optional, defaults to 4.
 * @var $isZeroBased bool Optional, defaults to FALSE.
 */
$totalItems = count($database);
$perPage = 5;
$requestedPage = isset($_GET['page']) ? strval($_GET['page']) : 1;
$padding = 4; // Optional
$isZeroBased = false; // Optional
$pagination = new SearchPagination($totalItems, $perPage, $requestedPage, $padding, $isZeroBased);

/**
 * Load the requested entries from the database only when the client requested an existing page.
 * Although it is possible to load probably useful items (the first or last ones, depends on the client's request).
 */
$entries = $pagination->isOnValidPage()
    ? array_slice($database, $pagination->getItemOffset(), $pagination->getItemLimit())
    : [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rayne\Pagination Examples</title>
	<style type="text/css">
		ul.pagination, ul.pagination li {
			display: inline;
		}

		.active {
			font-weight: bold;
		}
	</style>
</head>
<body>

<h1>Rayne\Pagination Examples</h1>

<p>
	This is the default <code>Rayne\Pagination</code> example with one-indexed pages and clever pagination boundaries (see <a href="#special-cases">Special Cases</a>).
	Visit <a href="https://github.com/rayne/pagination">GitHub</a> to download the library.
</p>

<h2>Pagination <?php printf('%s/%s', $pagination->getCurrentPage(), $pagination->getLastPage()); ?></h2>

<h3>Simple Example</h3>

<?php require 'PHP/ExampleSimple.html.php'; ?>

<h3>Advanced Example (hides redundant controls)</h3>

<?php require 'PHP/ExampleAdvanced.html.php'; ?>

<h2>Entries By Page</h2>

<p><?php

if ($entries) {
    printf(
        'OFFSET=%s, LIMIT=%s, ENTRIES=%s',
        $pagination->getItemOffset(),
        $pagination->getItemLimit(),
        implode(',', $entries)
    );
} else {
    printf('No entries found for invalid page: `%s`.', htmlspecialchars($requestedPage));
}

?></p>

<h2 id="special-cases">Special Cases</h2>

<ul>
	<li><a href="?page=-10">Page -10</a>: pagination begins with first page</li>
	<li><a href="?page=9000">Page 9000</a>: pagination ends with last page</li>
	<li><a href="?page=9a">Page 9a</a>: pagination begins with first page, as <code>9a</code> isn't an integer</li>
</ul>

<h2>Notes</h2>

<ul>
	<li>The library doesn't define any markup</li>
	<li>Pagination is also possible with zero indexed pages (<code>$isZeroBased=true</code>)</li>
	<li>It is possible to fetch the offsets for displaying the first and last entries on special pages (see <a href="#special-cases">Special Cases</a> above and <a href="#debug">Debug</a> below)</li>
</ul>

<h2 id="debug">Debug</h2>

<pre><code><?php print_r($pagination->toArray()); ?></code></pre>

</body>
</html>
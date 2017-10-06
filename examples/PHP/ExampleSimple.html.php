<?php

use Rayne\Pagination\SearchPaginationInterface;

/** @var $pagination SearchPaginationInterface */

echo '<ul class="pagination">'."\n";
echo "\t".'<li><a href="?page=' . $pagination->getFirstPage() . '">First</a></li>'."\n";
echo "\t".'<li><a href="?page=' . $pagination->getPreviousPage() . '">Previous</a></li>'."\n";

for ($page = $pagination->getFirstPageInRange(); $page <= $pagination->getLastPageInRange(); $page++) {
    $strActive = $pagination->isOnValidPage() && $pagination->getCurrentPage() == $page ? ' class="active"' : '';
    printf("\t".'<li><a href="?page=%1$s" %2$s>%1$s</a></li>'."\n", $page, $strActive);
}

echo "\t".'<li><a href="?page=' . $pagination->getNextPage() . '">Next</a></li>'."\n";
echo "\t".'<li><a href="?page=' . $pagination->getLastPage() . '">Last</a></li>'."\n";
echo '</ul>'."\n";

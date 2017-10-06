<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination;

/**
 * Implementations calculate pagination and (database) query information.
 * Invalid pages get corrected to appropriate (first or last page) ones.
 * The method #isOnInvalidPage verifies whether the requested page is (in)valid.
 *
 * @see https://developer.yahoo.com/ypatterns/navigation/pagination/search.html
 * @see #toArray
 * @see #getItemLimit
 * @see #getItemOffset
 * @see #getSequence
 */
interface SearchPaginationInterface
{
    /**
     * @see #getFirstPage
     */
    const FIRST = 'first';

    /**
     * @see #getFirstPageInRange
     */
    const BEGIN = 'begin';

    /**
     * @see #getPreviousPage
     */
    const PREVIOUS = 'previous';

    /**
     * @see #getCurrentPage
     */
    const PAGE = 'page';

    /**
     * @see #getNextPage
     */
    const NEXT = 'next';

    /**
     * @see #getLastPageInRange
     */
    const END = 'end';

    /**
     * @see #getLastPage
     */
    const LAST = 'last';

    /**
     * @see #getItemOffset
     */
    const OFFSET = 'offset';

    /**
     * @see #getItemLimit
     */
    const LIMIT = 'limit';

    /**
     * @return int First page, even when there are no items.
     */
    public function getFirstPage();

    /**
     * @return int First page in range.
     */
    public function getFirstPageInRange();

    /**
     * @return int The previous page or - when invalid - the first page.
     */
    public function getPreviousPage();

    /**
     * @return int The current page or - when invalid - an appropriate (first or last) page.
     * @see #getCorrectedPage
     * @see #isOnInvalidPage
     */
    public function getCurrentPage();

    /**
     * @return int The next page or - when invalid - the last page.
     */
    public function getNextPage();

    /**
     * @return int Last page in range.
     */
    public function getLastPageInRange();

    /**
     * @return int The last page. Defaults to the first page when there are no items.
     */
    public function getLastPage();

    /**
     * @return bool Whether the current page is the first one.
     */
    public function isOnFirstPage();

    /**
     * @return bool Whether the current page is the last one.
     */
    public function isOnLastPage();

    /**
     * @return bool Whether the injected current page is a valid one.
     */
    public function isOnValidPage();

    /**
     * @return int Items per page.
     */
    public function getItemsPerPage();

    /**
     * @return int Count of all items.
     */
    public function getTotalItems();

    /**
     * @return int Count of total pages.
     */
    public function getTotalPages();

    /**
     * @return int Item offset.
     */
    public function getItemOffset();

    /**
     * @return int Item limit.
     */
    public function getItemLimit();

    /**
     * @return array Sequence from first to last page in range, for instance "1,2,3".
     */
    public function getSequence();

    /**
     * Returns an array for debugging and templating.
     *
     * @return array Array of integers with keys first, begin, previous, page, next, end, last, offset and limit.
     * @see #FIRST
     * @see #BEGIN
     * @see #PREVIOUS
     * @see #PAGE
     * @see #NEXT
     * @see #END
     * @see #LAST
     * @see #OFFSET
     * @see #LIMIT
     */
    public function toArray();
}

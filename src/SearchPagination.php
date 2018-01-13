<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination;

class SearchPagination implements SearchPaginationInterface
{
    /**
     * @var int
     */
    protected $rangeBegin;

    /**
     * @var int
     */
    protected $rangeEnd;

    /**
     * @var int
     */
    private $pagePadding;

    /**
     * @var bool
     */
    private $isZeroBased = false;

    /**
     * @var int
     */
    private $totalItems;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int `-1` when invalid.
     */
    private $userProvidedCurrentPage;

    /**
     * @param int $totalItems Item count.
     * @param int $itemsPerPage Items per page.
     * @param mixed $currentPage Selected page. Only integers and string encoded integers are candidates for being valid values.
     *                           Invalid values get replaced by the next appropriate page (first or last).
     * @param int $pagePadding Page padding, eg. padding of two: [ 1 ][ 2 ][PAGE][ 3 ][ 4 ].
     * @param bool $isZeroBased Whether pages are zero (or one) based.
     */
    public function __construct($totalItems, $itemsPerPage, $currentPage, $pagePadding = 4, $isZeroBased = false)
    {
        $this->pagePadding = (int) $pagePadding;
        $this->totalItems = (int) $totalItems;
        $this->itemsPerPage = (int) $itemsPerPage;
        $this->isZeroBased = (bool) $isZeroBased;

        if (is_int($currentPage) || (is_string($currentPage) && $currentPage === (string) (int) $currentPage)) {
            $this->userProvidedCurrentPage = (int) $currentPage;
        } else {
            // Invalid page.
            $this->userProvidedCurrentPage = -1;
        }

        $this->setupRange();
    }

    /**
     * Calculates range attributes.
     *
     * <pre><code>Example: PAGE=1 PADDING=4 PAGES=INF BASE=1
     *
     * [ 1 ][ 2 ][ 3 ][ 4 ][ 5 ][ 6 ][ 7 ][ 8 ][ 9 ]
     *  ***                                     ***
     * BEGIN/PAGE                               END
     *
     * BEGIN=((1-4)+4)
     * BEGIN_BONUS=-(-3)+1
     * END=((1+4)+0)+4
     * END_BONUS=0
     * RANGE_BEGIN=1
     * RANGE_END=9</pre></code>
     *
     * <pre><code>Example: PAGE=4 PADDING=4 PAGES=6 BASE=1
     *
     * [ 1 ][ 2 ][ 3 ][ 4 ][ 5 ][ 6 ]
     *  ***            ***       ***
     * BEGIN          PAGE       END
     *
     * BEGIN=max(1,((4-4)+1)-2)
     * BEGIN_BONUS=1
     * END=min(6,((4+4)-2)+1)
     * END_BONUS=(8-6)
     * RANGE_BEGIN=1
     * RANGE_END=6</pre></code>
     *
     * <pre><code>Example: PAGE=1 PADDING=2 PAGES=1 BASE=1
     *
     * [ 1 ]
     *  ***
     * BEGIN/PAGE/END
     *
     * BEGIN=max(1,((1-2)+2)-2)
     * BEGIN_BONUS=(-(-1)+1)
     * END=min(1,((1+2)-2)+2))
     * END_BONUS=(3-1)
     * RANGE_BEGIN=1
     * RANGE_END=1</pre></code>
     *
     * <pre><code>Example: PAGE=0 PADDING=4 PAGES=INF BASE=0
     *
     * [ 0 ][ 1 ][ 2 ][ 3 ][ 4 ][ 5 ][ 6 ][ 7 ][ 8 ]
     *  ***                                     ***
     * BEGIN/PAGE                               END
     *
     * BEGIN=(0-4)+5
     * BEGIN_BONUS=-(-4)+1
     * END=min(INF,((0+4)-0)+5
     * END_BONUS=0
     * RANGE_BEGIN=1
     * RANGE_END=9</pre></code>
     */
    private function setupRange()
    {
        $begin = $this->getCurrentPage() - $this->pagePadding;
        $beginBonus = $begin < $this->getFirstPage() ? - $begin + $this->getFirstPage() : 0;
        $begin = $beginBonus + $begin;

        $end = $this->getCurrentPage() + $this->pagePadding;
        $endBonus = $end > $this->getLastPage() ? $end - $this->getLastPage() : 0;
        $end = $end - $endBonus;

        if ($beginBonus > 0) {
            $end = min($this->getLastPage(), $end + $beginBonus);
        }

        if ($endBonus > 0) {
            $begin = max($this->getFirstPage(), $begin - $endBonus);
        }

        $this->rangeBegin = $begin;
        $this->rangeEnd = $end;
    }

    /**
     * @inheritdoc
     */
    public function getFirstPage()
    {
        return $this->isZeroBased ? 0 : 1;
    }

    /**
     * @inheritdoc
     */
    public function getFirstPageInRange()
    {
        return $this->rangeBegin;
    }

    /**
     * @inheritdoc
     */
    public function getPreviousPage()
    {
        return max($this->getFirstPage(), $this->getCurrentPage() - 1);
    }

    /**
     * @inheritdoc
     */
    public function getCurrentPage()
    {
        return max($this->getFirstPage(), min($this->getLastPage(), $this->userProvidedCurrentPage));
    }

    /**
     * @inheritdoc
     */
    public function getNextPage()
    {
        return min($this->getCurrentPage() + 1, $this->getLastPage());
    }

    /**
     * @inheritdoc
     */
    public function getLastPageInRange()
    {
        return $this->rangeEnd;
    }

    /**
     * @inheritdoc
     */
    public function getLastPage()
    {
        // Zero-based: LAST = max(0, TOTAL + 0 - 1)
        // One-based:  LAST = max(1, TOTAL + 1 - 1)
        return (int) max($this->getFirstPage(), $this->getTotalPages() + $this->getFirstPage() - 1);
    }

    /**
     * @inheritdoc
     */
    public function isOnFirstPage()
    {
        return $this->getCurrentPage() == $this->getFirstPage();
    }

    /**
     * @inheritdoc
     */
    public function isOnLastPage()
    {
        return $this->getCurrentPage() == $this->getLastPage();
    }

    /**
     * @inheritdoc
     */
    public function isOnValidPage()
    {
        return $this->getCurrentPage() == $this->userProvidedCurrentPage;
    }

    /**
     * @inheritdoc
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * @inheritdoc
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }

    /**
     * @inheritdoc
     */
    public function getTotalPages()
    {
        return (int) ceil($this->getTotalItems() / $this->getItemsPerPage());
    }

    /**
     * @inheritdoc
     */
    public function getItemOffset()
    {
        // Zero-based: OFFSET = ITEMS_PER_PAGE * (PAGE - 0)
        // One-based:  OFFSET = ITEMS_PER_PAGE * (PAGE - 1)
        return (int) $this->getItemsPerPage() * ($this->getCurrentPage() - $this->getFirstPage());
    }

    /**
     * @inheritdoc
     */
    public function getItemLimit()
    {
        return $this->getItemsPerPage();
    }

    /**
     * @inheritdoc
     */
    public function getSequence()
    {
        return range($this->getFirstPageInRange(), $this->getLastPageInRange());
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return [
            self::FIRST => $this->getFirstPage(),
            self::BEGIN => $this->getFirstPageInRange(),
            self::PREVIOUS => $this->getPreviousPage(),
            self::PAGE => $this->getCurrentPage(),
            self::NEXT => $this->getNextPage(),
            self::END => $this->getLastPageInRange(),
            self::LAST => $this->getLastPage(),
            self::OFFSET => $this->getItemOffset(),
            self::LIMIT => $this->getItemLimit(),
        ];
    }
}

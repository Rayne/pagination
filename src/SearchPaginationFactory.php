<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination;

/**
 *
 */
class SearchPaginationFactory
{
    /**
     * @var int
     */
    private $itemsPerPage = 20;

    /**
     * @var int
     */
    private $pagePadding = 4;

    /**
     * @var bool
     */
    private $isZeroBased = false;

    /**
     * @return SearchPaginationFactory
     */
    public static function instance()
    {
        static $instance;

        if (!$instance) {
            $instance = new SearchPaginationFactory;
        }

        return $instance;
    }

    /**
     * @param int $totalItems
     * @param int $currentPage
     * @return SearchPagination
     */
    public function build($totalItems, $currentPage)
    {
        return new SearchPagination($totalItems, $this->itemsPerPage, $currentPage, $this->pagePadding, $this->isZeroBased);
    }

    /**
     * @param int $itemsPerPage
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * @param int $pagePadding
     * @return SearchPaginationFactory
     */
    public function setPagePadding($pagePadding)
    {
        $this->pagePadding = $pagePadding;
        return $this;
    }

    /**
     * @param bool $isZeroBased
     * @return SearchPaginationFactory
     */
    public function setIsZeroBased($isZeroBased)
    {
        $this->isZeroBased = $isZeroBased;
        return $this;
    }
}

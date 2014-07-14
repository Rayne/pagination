<?php

namespace Rayne\Validation\Complex;

use PHPUnit_Framework_TestCase;
use Rayne\Pagination\SearchPagination;
use Rayne\Pagination\SearchPaginationImpl;

class PaginationImplTest extends PHPUnit_Framework_TestCase {
	/**
	 * Builds SearchPaginationImpl objects and verifies constructor values.
	 *
	 * @param $totalItems
	 * @param $itemsPerPage
	 * @param $currentPage
	 * @param $pagePadding
	 * @param $isZeroBased
	 * @return SearchPaginationImpl
	 */
	private function buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased) {
		$p = new SearchPaginationImpl($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame($itemsPerPage, $p->getItemLimit());
		$this->assertSame($itemsPerPage, $p->getItemsPerPage());
		$this->assertSame($totalItems, $p->getTotalItems());
		return $p;
	}

	/**
	 * Verifies derivable properties.
	 *
	 * @param SearchPagination $p
	 * @param $firstPage
	 * @param $firstPageInRange
	 * @param $previousPage
	 * @param $currentPage
	 * @param $nextPage
	 * @param $lastPageInRange
	 * @param $lastPage
	 * @param $offset
	 * @param $limit
	 */
	private function buildExpectedToArrayResult(SearchPagination $p, $firstPage, $firstPageInRange, $previousPage, $currentPage, $nextPage, $lastPageInRange, $lastPage, $offset, $limit) {
		$this->assertSame($firstPage, $p->getFirstPage());
		$this->assertSame($firstPageInRange, $p->getFirstPageInRange());
		$this->assertSame($previousPage, $p->getPreviousPage());
		$this->assertSame($currentPage, $p->getCurrentPage());
		$this->assertSame($nextPage, $p->getNextPage());
		$this->assertSame($lastPageInRange, $p->getLastPageInRange());
		$this->assertSame($lastPage, $p->getLastPage());
		$this->assertSame($firstPage == $currentPage, $p->isOnFirstPage());
		$this->assertSame($currentPage == $lastPage, $p->isOnLastPage());
		$this->assertSame(range($firstPageInRange, $lastPageInRange), $p->getSequence());
		$this->assertSame($offset, $p->getItemOffset());
		$this->assertSame($limit, $p->getItemLimit());

		$this->assertSame(array(
			SearchPagination::FIRST => $firstPage,
			SearchPagination::BEGIN => $firstPageInRange,
			SearchPagination::PREVIOUS => $previousPage,
			SearchPagination::PAGE => $currentPage,
			SearchPagination::NEXT => $nextPage,
			SearchPagination::END => $lastPageInRange,
			SearchPagination::LAST => $lastPage,
			SearchPagination::OFFSET => $offset,
			SearchPagination::LIMIT => $limit,
		), $p->toArray());
	}

	public function testFirstPage_oneBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 1;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 1, 1, 1, 2, 9, 10, 0, $itemsPerPage);
	}

	public function testFirstPage_zeroBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 0;
		$pagePadding = 4;
		$isZeroBased = true;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 0, 0, 0, 0, 1, 8, 9, 0, $itemsPerPage);
	}

	public function testLastPage_oneBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 10;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 2, 9, 10, 10, 10, 10, 90, $itemsPerPage);
	}

	public function testLastPage_zeroBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 9;
		$pagePadding = 4;
		$isZeroBased = true;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 0, 1, 8, 9, 9, 9, 9, 90, $itemsPerPage);
	}

	public function testSecondPage_oneBased() {
		$totalItems = 1000;
		$itemsPerPage = 10;
		$currentPage = 2;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(100, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 1, 1, 2, 3, 9, 100, 10, $itemsPerPage);
	}

	public function testBetweenPage_oneBased() {
		$totalItems = 1000;
		$itemsPerPage = 10;
		$currentPage = 50;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(100, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 46, 49, 50, 51, 54, 100, 490, $itemsPerPage);
	}

	public function testBetweenPage_zeroBased() {
		$totalItems = 1000;
		$itemsPerPage = 10;
		$currentPage = 49;
		$pagePadding = 4;
		$isZeroBased = true;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(100, $p->getTotalPages());
		$this->assertSame(true, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 0, 45, 48, 49, 50, 53, 99, 490, $itemsPerPage);
	}

	/**
	 * As the requested page is smaller than the first page, the beginning of the pagination is expected to be returned.
	 */
	public function testBeginOutOfBound_zeroBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = -20;
		$pagePadding = 4;
		$isZeroBased = true;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(false, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 0, 0, 0, 0, 1, 8, 9, 0, $itemsPerPage);
	}

	/**
	 * As the requested page is smaller than the first page, the beginning of the pagination is expected to be returned.
	 */
	public function testBeginOutOfBound_oneBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = -20;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(false, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 1, 1, 1, 2, 9, 10, 0, $itemsPerPage);
	}

	/**
	 * As the requested page is greater than the last page, the end of the pagination is expected to be returned.
	 */
	public function testEndOutOfBound_zeroBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 20;
		$pagePadding = 4;
		$isZeroBased = true;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(false, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 0, 1, 8, 9, 9, 9, 9, 90, $itemsPerPage);
	}

	/**
	 * As the requested page is greater than the last page, the end of the pagination is expected to be returned.
	 */
	public function testEndOutOfBound_oneBased() {
		$totalItems = 100;
		$itemsPerPage = 10;
		$currentPage = 20;
		$pagePadding = 4;
		$isZeroBased = false;

		$p = $this->buildPaginationObject($totalItems, $itemsPerPage, $currentPage, $pagePadding, $isZeroBased);
		$this->assertSame(10, $p->getTotalPages());
		$this->assertSame(false, $p->isOnValidPage());
		$this->buildExpectedToArrayResult($p, 1, 2, 9, 10, 10, 10, 10, 90, $itemsPerPage);
	}
}
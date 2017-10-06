<?php

namespace Rayne\Pagination\Filter;

class FilterPagination {
	/**
	 * @var bool
	 */
	private $isOnValidPage = false;

	/**
	 * @var int
	 */
	private $currentPos = -1;

	/**
	 * @var array Array of FilterPage objects.
	 */
	private $pages;

	function __construct(FilterPages $pages, $currentPage) {
		$this->pages = $pages->getPages();
		$this->currentPage = is_scalar($pages) ? (string) $currentPage : null;

		// Pages might be unsorted, so we have to walk them one by one.
		/** @var $pos int */
		/** @var $page FilterPage */
		foreach ($this->pages as $pos => $page) {
			if ($page->getPage() === $this->currentPage) {
				$this->isOnValidPage = true;
				$this->currentPos = $pos;
				break;
			}
		}
	}

	/**
	 * @param int $pos
	 * @return FilterPage|null The requested page when existing or NULL.
	 */
	private function getPage($pos) {
		return isset($this->pages[$pos]) ? $this->pages[$pos] : null;
	}

	/**
	 * @return int Could be invalid (-1).
	 */
	private function getCurrentPos() {
		return $this->currentPos;
	}

	/**
	 * @return FilterPage|null First page or NULL (no pages).
	 */
	function getFirstPage() {
		return $this->getPage(0);
	}

	/**
	 * @return FilterPage|null Previous page (when existing), first page (current one is the first) or NULL.
	 */
	function getPreviousPage() {
		return $this->getPage(max(0, $this->getCurrentPos() - 1));
	}

	/**
	 * @return FilterPage|null Current page (when existing) or NULL.
	 * @see #isOnValidPage
	 */
	function getCurrentPage() {
		return $this->getPage($this->getCurrentPos());
	}

	/**
	 * @return FilterPage Next page (when existing), last page (current one is the last) or NULL.
	 */
	function getNextPage() {
		return $this->getPage(min($this->getCurrentPos() + 1, $this->getTotalPages() - 1));
	}

	/**
	 * @return FilterPage Last page or NULL (no pages).
	 */
	function getLastPage() {
		return $this->getPage($this->getTotalPages() - 1);
	}

	/**
	 * @return bool Whether the current page is the first one.
	 */
	function isOnFirstPage() {
		return $this->isOnValidPage() && $this->getFirstPage() == $this->getCurrentPage();
	}

	/**
	 * @return bool Whether the current page is the last one.
	 */
	function isOnLastPage() {
		return $this->isOnValidPage() && $this->getCurrentPage() == $this->getLastPage();
	}

	/**
	 * @return bool Whether the injected current page is a valid one.
	 */
	function isOnValidPage() {
		return $this->isOnValidPage;
	}

	/**
	 * @return int Count of total pages.
	 */
	function getTotalPages() {
		return count($this->pages);
	}

	/**
	 * Returns an array for debugging and templating.
	 *
	 * @return array
	 */
	function toArray() {
		/**
		 * @param FilterPage $page
		 * @return array|null
		 */
		$callback = function(FilterPage $page = null) {
			return $page == null ? null : $page->toArray();
		};

		return array(
			'pages' => array_map($callback, $this->pages),
			'page' => $callback($this->getCurrentPage()),
			'first' => $callback($this->getFirstPage()),
			'previous' => $callback($this->getPreviousPage()),
			'next' => $callback($this->getNextPage()),
			'last' => $callback($this->getLastPage()),
			'total' => $this->getTotalPages(),
		);
	}
}
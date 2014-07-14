<?php

namespace Rayne\Pagination\Filter;

/**
 * Mutable collection of FilterPage objects.
 */
class FilterPages {
	private $pages = array();

	/**
	 * @param FilterPage $page
	 */
	function addPage(FilterPage $page) {
		$this->pages[] = $page;
	}

	/**
	 * @param mixed $callback usort() compatible callback. FilterPage objects are callback arguments.
	 * @see #toArray
	 */
	function sort($callback) {
		usort($this->pages, $callback);
	}

	/**
	 * @return array Array of sorted FilterPage objects.
	 */
	function getPages() {
		return $this->pages;
	}
}
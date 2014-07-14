<?php

namespace Rayne\Pagination\Filter;

/**
 * Immutable filter page description with page, title and optional item count.
 */
class FilterPage {
	private $page;
	private $title;
	private $count;

	/**
	 * @param string $page
	 * @param string $title
	 * @param int $count
	 */
	function __construct($page, $title, $count = 0) {
		$this->page = (string) $page;
		$this->title = (string) $title;
		$this->count = (int) $count;
	}

	/**
	 * @return int
	 */
	function getCount() {
		return $this->count;
	}

	/**
	 * @return string
	 */
	function getPage() {
		return $this->page;
	}

	/**
	 * @return string
	 */
	function getTitle() {
		return $this->title;
	}

	function toArray() {
		return array(
			'count' => $this->getCount(),
			'page' => $this->getPage(),
			'title' => $this->getTitle(),
		);
	}
}
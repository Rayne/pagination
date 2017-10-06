<?php

namespace Rayne\Pagination\Filter;

/**
 * Mutable collection of FilterPage objects.
 */
class FilterPages
{
    private $pages = [];

    /**
     * @param FilterPage $page
     */
    public function addPage(FilterPage $page)
    {
        $this->pages[] = $page;
    }

    /**
     * @param mixed $callback usort() compatible callback. FilterPage objects are callback arguments.
     * @see #toArray
     */
    public function sort($callback)
    {
        usort($this->pages, $callback);
    }

    /**
     * @return array Array of sorted FilterPage objects.
     */
    public function getPages()
    {
        return $this->pages;
    }
}

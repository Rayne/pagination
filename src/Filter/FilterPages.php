<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination\Filter;

/**
 * Mutable collection of FilterPage objects.
 */
class FilterPages
{
    /**
     * @var FilterPage[]
     */
    private $pages = [];

    /**
     * @param FilterPage $page
     */
    public function addPage(FilterPage $page)
    {
        $this->pages[] = $page;
    }

    /**
     * @param mixed $callback `usort()` compatible callback. The callback will be faced with two `FilterPage` objects as arguments.
     */
    public function sort($callback)
    {
        usort($this->pages, $callback);
    }

    /**
     * @return FilterPage[] Array of sorted FilterPage objects.
     */
    public function getPages()
    {
        return $this->pages;
    }
}

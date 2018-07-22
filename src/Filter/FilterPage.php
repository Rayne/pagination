<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination\Filter;

/**
 * Immutable filter page description with page, title and optional item count.
 */
class FilterPage
{
    /**
     * @var string
     */
    private $page;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $count;

    /**
     * @param string $page Page slug or ID, e.g. a letter or machine readable category name.
     * @param string $title Human readable title, e.g. a letter or a translatable or translated category name.
     * @param int $count The amount of records represented by this page. Can be ignored when the count is not relevant.
     */
    public function __construct($page, $title, $count = 0)
    {
        $this->page = (string) $page;
        $this->title = (string) $title;
        $this->count = (int) $count;
    }

    /**
     * @return int The amount of records represented by this page. Can be ignored when the count is not relevant.
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string Page slug or ID, e.g. a letter or machine readable category name.
     *
     * TODO Rename to getId() or getSlug() or getMachineName() or getName()
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return string Human readable title, e.g. a letter or a translatable or translated category name.
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function toArray()
    {
        return [
            'count' => $this->getCount(),
            'page' => $this->getPage(),
            'title' => $this->getTitle(),
        ];
    }
}

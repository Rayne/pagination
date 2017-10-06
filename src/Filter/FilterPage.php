<?php

namespace Rayne\Pagination\Filter;

/**
 * Immutable filter page description with page, title and optional item count.
 */
class FilterPage
{
    private $page;
    private $title;
    private $count;

    /**
     * @param string $page
     * @param string $title
     * @param int $count
     */
    public function __construct($page, $title, $count = 0)
    {
        $this->page = (string) $page;
        $this->title = (string) $title;
        $this->count = (int) $count;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return string
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

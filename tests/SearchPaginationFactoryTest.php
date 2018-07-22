<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination;

use PHPUnit\Framework\TestCase;

class SearchPaginationFactoryTest extends TestCase
{
    public function testSharedInstance()
    {
        $this->assertSame(SearchPaginationFactory::instance(), SearchPaginationFactory::instance());
    }

    public function testBuildArguments()
    {
        $factory = new SearchPaginationFactory;
        $instance = $factory->build(1000, 10);

        $this->assertSame(1000, $instance->getTotalItems());
        $this->assertSame(10, $instance->getCurrentPage());
    }

    public function testIsZeroBased()
    {
        $factory = new SearchPaginationFactory;

        // Check default value (pagination is one based).
        $this->assertSame(1, $factory->build(1000, 10)->getFirstPage());

        $factory->setIsZeroBased(true);
        $this->assertSame(0, $factory->build(1000, 10)->getFirstPage());

        $factory->setIsZeroBased(false);
        $this->assertSame(1, $factory->build(1000, 10)->getFirstPage());
    }

    public function testItemsPerPage()
    {
        $factory = new SearchPaginationFactory;

        // Check default value (20 items per page => 1000/20 = 50 pages).
        $this->assertSame(50, $factory->build(1000, 10)->getTotalPages());

        $factory->setItemsPerPage(25);
        $this->assertSame(40, $factory->build(1000, 10)->getTotalPages());
    }

    public function testPagePadding()
    {
        $factory = new SearchPaginationFactory;

        // Check default value (padding of four => (10 - 4) is the first page in range).
        $this->assertSame(6, $factory->build(1000, 10)->getFirstPageInRange());

        $factory->setPagePadding(2);
        $this->assertSame(8, $factory->build(1000, 10)->getFirstPageInRange());
    }
}

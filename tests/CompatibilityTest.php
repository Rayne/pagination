<?php

/**
 * (c) Dennis Meckel
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace Rayne\Pagination;

use PHPUnit\Framework\TestCase;

class CompatibilityTest extends TestCase
{
    /**
     * Casting floats to strings changed with PHP 7.0.2.
     */
    public function testFloatToStringCasting()
    {
        $this->assertSame(-0.0, +0.0);
        $this->assertNotSame((string) -0.0, (string) +0.0);

        $expected = version_compare(PHP_VERSION, '7.0.2') < 0 ? '0' : '-0';

        $this->assertSame('0', (string) +0.0);
        $this->assertSame($expected, (string) -0.0);
        $this->assertSame('0', (string) -0);
        $this->assertSame('0', (string) +0);

        if (version_compare(PHP_VERSION, '7.0.2') < 0) {
            $this->assertSame('-0', (string) -0.0);
        } else {
            $this->assertSame('-0', (string) -0.0);
        }
    }
}

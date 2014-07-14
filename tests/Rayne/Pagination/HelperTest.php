<?php

namespace Rayne\Validation\Complex;

use PHPUnit_Framework_TestCase;
use Rayne\Pagination\Helper;
use stdClass;

class HelperTest extends PHPUnit_Framework_TestCase {
	public function integerProvider() {
		return array_chunk(array(
			'-1', '0', '1', // Strings
			-1, -0, 0, +0, 1, +1, // Integers
			-1.0, -0.0, 0.0, +0.0, +1.0, // Floats
			// Floats
		), 1);
	}

	public function nonIntegerProvider() {
		return array_chunk(array(
			'-0', '+0', '+1', // String encoded integers with superfluous signs
			'0x', '0xFF', // Integer casting (or cutting) not supported
			'1.0', '1,0', // String encoded floats are not allowed
			1.1, // "Non-integer floats" (decimal place != 0)
			null, array(), new stdClass(), // Non-scalars
		), 1);
	}

	/**
	 * @dataProvider integerProvider
	 */
	public function testIntegers($value) {
		$this->assertTrue(Helper::isInteger($value));
	}

	/**
	 * @dataProvider nonIntegerProvider
	 */
	public function testNonIntegers($value) {
		$this->assertFalse(Helper::isInteger($value));
	}
}
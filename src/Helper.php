<?php

namespace Rayne\Pagination;

abstract class Helper
{
    /**
     * Valid values: "-1", "0", "1", integers and "integer floats" (decimal place == 0).
     *
     * Invalid values: "-0", "+0", "+1", "0x", "0xFF", non-scalars and "non-integer floats" (decimal place != 0).
     *
     * @param mixed $value
     * @return bool Whether the value is an integer without superfluous sign (integer type or string formatted integer).
     */
    public static function isInteger($value)
    {
        return is_scalar($value) && (string) $value === (string) (int) $value;
    }
}

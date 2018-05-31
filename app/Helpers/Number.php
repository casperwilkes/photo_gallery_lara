<?php

if (!function_exists('format_bytes')) {
    /**
     * Converts a number of bytes to a human readable number by taking the
     * number of that unit that the bytes will go into it. Supports TB value.
     *
     * Note: Integers in PHP are limited to 32 bits, unless they are on 64 bit
     * architectures, then they have 64 bit size. If you need to place the
     * larger size then what the PHP integer type will hold, then use a string.
     * It will be converted to a double, which should always have 64 bit length.
     *
     * @param   integer
     * @param   integer
     * @return  boolean|string
     */
    function format_bytes($bytes = 0, $decimals = 0) {
        $type = array(
            'TB' => 1099511627776,  // pow( 1024, 4)
            'GB' => 1073741824,     // pow( 1024, 3)
            'MB' => 1048576,        // pow( 1024, 2)
            'KB' => 1024,           // pow( 1024, 1)
            'B ' => 1,              // pow( 1024, 0)
        );

        foreach ($type as $unit => $mag) {
            if ((float) $bytes >= $mag) {
                return sprintf('%01.' . $decimals . 'f', $bytes / $mag) . ' ' . $unit;
            }
        }

        return false;
    }
}




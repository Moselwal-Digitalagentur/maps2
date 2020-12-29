<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Tca\Type;

/**
 * Reduce floating values to 6 digits behind point
 */
class FloatType
{
    /**
     * @return string
     */
    public function returnFieldJS(): string
    {
        return '
            return value;
        ';
    }

    /**
     * @param string $value
     * @param $is_in
     * @param $set
     * @return string
     */
    public function evaluateFieldValue(string $value, $is_in, &$set): string
    {
        return number_format((float)$value, 6);
    }
}

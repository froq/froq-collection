<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Calc-Average Trait.
 *
 * Represents a trait that provides `average()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CalcAverageTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcAverageTrait
{
    /**
     * Calculate the average of values in data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function average(int $precision = null): int|float
    {
        $ret = array_average($this->data);

        if ($precision !== null) {
            $ret = round($ret, $precision);
        }

        return $ret;
    }
}

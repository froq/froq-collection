<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Calc-Sum Trait.
 *
 * Represents a trait that provides `sum()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CalcSumTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcSumTrait
{
    /**
     * Calculate the sum of values in data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function sum(int $precision = null): int|float
    {
        if (empty($this->data)) {
            return 0;
        }

        return ($precision === null)
             ? array_sum($this->data)
             : round(array_sum($this->data), $precision);
    }
}

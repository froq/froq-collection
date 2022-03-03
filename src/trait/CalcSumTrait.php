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
 * A trait, provides `sum()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CalcSumTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcSumTrait
{
    /**
     * Calculate the sum of values of data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function sum(int $precision = null): int|float
    {
        if (!$this->data) {
            return 0;
        }

        $ret = array_sum($this->data);
        if ($precision !== null) {
            $ret = round($ret, $precision);
        }

        return $ret;
    }
}

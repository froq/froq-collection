<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `sum()` method.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\CalcSumTrait
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
        $ret = 0;

        if ($this->data) {
            $ret = array_sum($this->data);
            if ($precision !== null) {
                $ret = round($ret, $precision);
            }
        }

        return $ret;
    }
}

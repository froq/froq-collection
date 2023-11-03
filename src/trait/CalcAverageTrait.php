<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `average()` and `avg()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\CalcAverageTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcAverageTrait
{
    /**
     * Calculate the average of values of data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function average(int $precision = null): int|float
    {
        $ret = 0;

        if ($this->data) {
            $ret = array_average($this->data);
            if ($precision !== null) {
                $ret = round($ret, $precision);
            }
        }

        return $ret;
    }

    /**
     * @alias average()
     */
    public function avg(...$args)
    {
        return $this->average(...$args);
    }
}

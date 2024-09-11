<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `avg()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\CalcAvgTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcAvgTrait
{
    /**
     * Calculate the average of values of data array.
     *
     * @param  int|null $precision
     * @return float
     */
    public function avg(int $precision = null): int|float
    {
        $ret = avg($this->data);

        return ($precision !== null) ? round($ret, $precision) : $ret;
    }
}

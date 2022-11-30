<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `product()` method.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\CalcProductTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcProductTrait
{
    /**
     * Calculate the product of values of data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function product(int $precision = null): int|float
    {
        $ret = 0;

        if ($this->data) {
            $ret = array_product($this->data);
            if ($precision !== null) {
                $ret = round($ret, $precision);
            }
        }

        return $ret;
    }
}

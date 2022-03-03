<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Calc-Product Trait.
 *
 * A trait, provides `product()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CalcProductTrait
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
        if ($this->data) {
            return 0;
        }

        $ret = array_product($this->data);
        if ($precision !== null) {
            $ret = round($ret, $precision);
        }

        return $ret;
    }
}

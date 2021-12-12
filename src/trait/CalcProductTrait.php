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
 * Represents a trait that provides `product()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CalcProductTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait CalcProductTrait
{
    /**
     * Calculate the product of values in data array.
     *
     * @param  int|null $precision
     * @return int|float
     */
    public function product(int $precision = null): int|float
    {
        if (empty($this->data)) {
            return 0;
        }

        return ($precision === null)
             ? array_product($this->data)
             : round(array_product($this->data), $precision);
    }
}
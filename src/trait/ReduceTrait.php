<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * Reduce Trait.
 *
 * A trait, provides `reduce()` and `reduceRight()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ReduceTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait ReduceTrait
{
    /**
     * Apply a reduce action on data array.
     *
     * @param  mixed    $carry
     * @param  callable $func
     * @return mixed
     */
    public function reduce(mixed $carry, callable $func): mixed
    {
        return Arrays::reduce($this->data, $carry, $func);
    }

    /**
     * Apply a reduce action on data array by right-to-left direction.
     *
     * @param  mixed    $carry
     * @param  callable $func
     * @return mixed
     */
    public function reduceRight(mixed $carry, callable $func): mixed
    {
        return Arrays::reduceRight($this->data, $carry, $func);
    }
}

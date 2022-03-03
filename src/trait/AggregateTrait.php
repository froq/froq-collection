<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * Aggregate Trait.
 *
 * A trait, provides `aggregate()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AggregateTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait AggregateTrait
{
    /**
     * Apply an aggregate action on data array.
     *
     * @param  callable   $func
     * @param  array|null $carry
     * @return static
     */
    public function aggregate(callable $func, array $carry = null): static
    {
        $data = Arrays::aggregate($this->data, $func, $carry);

        return new static($data);
    }
}

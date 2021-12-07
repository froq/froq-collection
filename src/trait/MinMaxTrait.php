<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Min-Max Trait.
 *
 * Represents a trait that provides `min()` and `max()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\MinMaxTrait
 * @author  Kerem Güneş
 * @since   5.12
 */
trait MinMaxTrait
{
    /**
     * Get min item from data array.
     *
     * @return mixed|null
     */
    public function min(): mixed
    {
        return $this->data ? min($this->data) : null;
    }

    /**
     * Get max item from data array.
     *
     * @return mixed|null
     */
    public function max(): mixed
    {
        return $this->data ? max($this->data) : null;
    }
}

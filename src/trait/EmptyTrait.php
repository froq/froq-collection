<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * A trait, provides `empty()`, `isEmpty()` and `isNotEmpty()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\EmptyTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait EmptyTrait
{
    /**
     * Empty data array.
     *
     * @return self
     */
    public function empty(): self
    {
        $this->data = [];

        return $this;
    }

    /**
     * Check whether data array is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Check whether data array is not empty.
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->data);
    }
}

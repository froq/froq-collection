<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * First-Last Trait.
 *
 * Represents a trait that provides `first()`, `firstKey()`, `last()` and `lastKey()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\FirstLastTrait
 * @author  Kerem Güneş
 * @since   5.24
 */
trait FirstLastTrait
{
    /**
     * Get first item or return null if no items on data array.
     *
     * @return mixed|null
     */
    public function first(): mixed
    {
        return array_first($this->data);
    }

    /**
     * Find first key or return null if no items data array.
     *
     * @return int|string|null
     */
    public function firstKey(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Get last item or return null if no items on data array.
     *
     * @return mixed|null
     */
    public function last(): mixed
    {
        return array_last($this->data);
    }

    /**
     * Find last key or return null if no items data array.
     *
     * @return int|string|null
     */
    public function lastKey(): int|string|null
    {
        return array_key_last($this->data);
    }
}

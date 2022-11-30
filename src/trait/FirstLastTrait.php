<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `first()`, `firstKey()`, `last()` and `lastKey()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\FirstLastTrait
 * @author  Kerem Güneş
 * @since   5.24
 */
trait FirstLastTrait
{
    /**
     * Get first value or return null if data array is empty.
     *
     * @return mixed|null
     */
    public function first(): mixed
    {
        return array_first($this->data);
    }

    /**
     * Find first key or return null if data array is empty.
     *
     * @return int|string|null
     */
    public function firstKey(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Get last value or return null if data array is empty.
     *
     * @return mixed|null
     */
    public function last(): mixed
    {
        return array_last($this->data);
    }

    /**
     * Find last key or return null if data array is empty.
     *
     * @return int|string|null
     */
    public function lastKey(): int|string|null
    {
        return array_key_last($this->data);
    }
}

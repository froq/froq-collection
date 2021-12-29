<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * Find Trait.
 *
 * Represents a trait entity that provides `find*()` utility methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\FindTrait
 * @author  Kerem Güneş
 * @since   5.24
 */
trait FindTrait
{
    /**
     * Find, like JavaScript Array.find().
     *
     * @param  callable $func
     * @param  bool     $reverse
     * @return mixed|null
     */
    public function find(callable $func, bool $reverse = false): mixed
    {
        return Arrays::find($this->data, $func, $reverse);
    }

    /**
     * Find all, kinda filter.
     *
     * @param  callable $func
     * @param  bool     $reverse
     * @param  bool     $useKeys
     * @return array<mixed|null>
     */
    public function findAll(callable $func, bool $reverse = false, bool $useKeys = true): array
    {
        return Arrays::findAll($this->data, $func, $reverse, $useKeys);
    }

    /**
     * Find, like JavaScript Array.findIndex().
     *
     * @param  callable $func
     * @param  bool     $reverse
     * @return any|null
     */
    public function findKey(callable $func, bool $reverse = false): int|string|null
    {
        return Arrays::findKey($this->data, $func, $reverse);
    }

    /**
     * Find all, kinda filter but returning keys.
     *
     * @param  callable $func
     * @param  bool     $reverse
     * @return array<int|string|null>
     */
    public function findKeys(callable $func, bool $reverse = false): array
    {
        return Arrays::findKeys($func, $reverse);
    }
}

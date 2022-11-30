<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * A trait, provides `find()`, `findAll()`, `findKey()` and `findKeys()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\FindTrait
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
     * @return array<mixed>|null
     */
    public function findAll(callable $func, bool $reverse = false): array|null
    {
        return Arrays::findAll($this->data, $func, $reverse);
    }

    /**
     * Find, like JavaScript Array.findIndex().
     *
     * @param  callable $func
     * @param  bool     $reverse
     * @return int|string|null
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
     * @return array<int|string>|null
     */
    public function findKeys(callable $func, bool $reverse = false): array|null
    {
        return Arrays::findKeys($this->data, $func, $reverse);
    }
}

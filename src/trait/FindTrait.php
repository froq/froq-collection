<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\common\trait\ReadOnlyCallTrait;
use froq\util\Arrays;

/**
 * Find Trait.
 *
 * Represents a trait entity that provides `find()` and `findAll()` methods.
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
     * @return any|null
     */
    public function find(callable $func)
    {
        return Arrays::find($this->data, $func);
    }

    /**
     * Find all, kinda filter.
     *
     * @param  callable $func
     * @param  bool     $useKeys
     * @return array
     */
    public function findAll(callable $func, bool $useKeys = true): array
    {
        return Arrays::findAll($this->data, $func, $useKeys);
    }
}

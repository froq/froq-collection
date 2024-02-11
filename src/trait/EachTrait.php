<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * A trait, provides `each()` and `eachKey()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\EachTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait EachTrait
{
    /**
     * Call given function for each pair (value/key) of data array.
     *
     * @param  callable    $func
     * @param  mixed    ...$funcArgs
     * @return self
     */
    public function each(callable $func, mixed ...$funcArgs): self
    {
        Arrays::each($this->data, $func, ...$funcArgs);

        return $this;
    }

    /**
     * Call given function for each key of data array.
     *
     * @param  callable    $func
     * @param  mixed    ...$funcArgs
     * @return self
     */
    public function eachKey(callable $func, mixed ...$funcArgs): self
    {
        Arrays::each(array_keys($this->data), $func, ...$funcArgs);

        return $this;
    }
}

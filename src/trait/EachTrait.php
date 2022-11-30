<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * A trait, provides `each()` method.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\EachTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait EachTrait
{
    /**
     * Call given function for each value of data array.
     *
     * @param  callable $func
     * @return self
     */
    public function each(callable $func): self
    {
        Arrays::each($this->data, $func);

        return $this;
    }

    /**
     * Call given function for each key of data array.
     *
     * @param  callable $func
     * @return self
     */
    public function eachKey(callable $func): self
    {
        Arrays::each(array_keys($this->data), $func);

        return $this;
    }
}

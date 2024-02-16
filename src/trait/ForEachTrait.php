<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `forEach()` and `forEachKey()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ForEachTrait
 * @author  Kerem Güneş
 * @since   7.3
 */
trait ForEachTrait
{
    /**
     * Call given function for each pair (value/key) of data array.
     *
     * @param  callable    $func
     * @param  mixed    ...$funcArgs
     * @return self
     */
    public function forEach(callable $func, mixed ...$funcArgs): self
    {
        foreach ($this->data as $key => $value) {
            $ret = $func($value, $key, $this, ...$funcArgs);

            // Normally must return void, but when false
            // returned, break this loop.
            if ($ret === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Call given function for each key of data array.
     *
     * @param  callable    $func
     * @param  mixed    ...$funcArgs
     * @return self
     */
    public function forEachKey(callable $func, mixed ...$funcArgs): self
    {
        foreach (array_keys($this->data) as $key) {
            $ret = $func($key, $this, ...$funcArgs);

            // Normally must return void, but when false
            // returned, break this loop.
            if ($ret === false) {
                break;
            }
        }

        return $this;
    }
}

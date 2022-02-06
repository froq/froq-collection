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
 * Map Trait.
 *
 * Represents a trait entity that provides `map()`, `mapKeys()` and `mapTo()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\MapTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait MapTrait
{
    /** @see froq\common\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply a map action on data array.
     *
     * @param  callable|string $func
     * @param  bool            $recursive
     * @param  bool            $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function map(callable|string $func, bool $recursive = false, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        // When a built-in type given.
        if (!is_callable($func)) {
            static $types = '~^(int|float|string|bool|array|object|null)$~';
            $type = $func;

            // Provide a mapper using settype().
            if (preg_test($types, $type)) {
                $func = function ($value) use ($type) {
                    settype($value, $type);
                    return $value;
                };
            }
        }

        $this->data = Arrays::map($this->data, $func, $recursive, $keepKeys);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange(__function__);
        }

        return $this;
    }

    /**
     * Apply a map action on data array keys.
     *
     * @param  callable|string $func
     * @param  bool            $recursive
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function mapKeys(callable $func, bool $recursive = false): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::mapKeys($this->data, $func, $recursive);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange(__function__);
        }

        return $this;
    }

    /**
     * Apply multi map actions on data array.
     *
     * @param  callable|string $funcs
     * @param  bool            $recursive
     * @param  bool            $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @since  6.0
     */
    public function mapMulti(string|array $funcs, bool $recursive = false, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        if (is_string($funcs)) {
            $funcs = explode('|', trim($funcs, '|'));
        }

        foreach ($funcs as $func) {
            $this->map($func, $recursive, $keepKeys);
        }

        return $this;
    }

    /**
     * Map all data items as properties to given class.
     *
     * @notice This method must be used on list-data containing objects, not single-dimensions.
     * @param  string   $class
     * @param  mixed ...$classArgs
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function mapTo(string $class, mixed ...$classArgs): self
    {
        return $this->map(function ($item) use ($class, $classArgs) {
            $object = new $class(...$classArgs);

            foreach ($item as $key => $value) {
                $object->$key = $value;
            }

            return $object;
        });
    }
}

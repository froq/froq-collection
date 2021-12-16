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
 * Represents a trait entity that provides `map()`, `mapAs()` and `mapTo()` methods.
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
     * @param  string|callable $func
     * @param  bool            $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function map(string|callable $func, bool $keepKeys = true): self
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

        $this->data = Arrays::map($this->data, $func, $keepKeys);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
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

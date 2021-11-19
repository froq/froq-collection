<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\collection\trait\ReadOnlyCallTrait;
use froq\common\exception\{InvalidArgumentException, RuntimeException};
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
    /** @see froq\collection\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply a map action on data array.
     *
     * @param  callable $func
     * @param  bool     $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function map(callable $func, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::map($this->data, $func, $keepKeys);

        return $this;
    }

    /**
     * Map all data items to given type.
     *
     * @param  string $type
     * @return self
     * @throws froq\common\exception\InvalidArgumentException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function mapAs(string $type): self
    {
        static $pattern = '~^(int|float|string|bool|array|object|null)$~';

        // Check given type for proper error message, not like settype()'s like.
        preg_test($pattern, $type) || throw new InvalidArgumentException(
            'Invalid type `%s`, valid type pattern: %s', [$type, $pattern]
        );

        return $this->map(function ($item) use ($type) {
            settype($item, $type);

            return $item;
        });
    }

    /**
     * Map all data items as properties to given class.
     *
     * @notice This method must be used on list-data containing objects, not single-dimensions.
     * @param  string $class
     * @return self
     * @throws froq\common\exception\RuntimeException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function mapTo(string $class): self
    {
        // Check class existence.
        class_exists($class) || throw new RuntimeException(
            'Class `%s` not exists', [$class]
        );

        $object = new $class();

        return $this->map(function ($item) use ($object) {
            $clone = clone $object;

            foreach ($item as $key => $value) {
                $clone->{$key} = $value;
            }

            return $clone;
        });
    }
}

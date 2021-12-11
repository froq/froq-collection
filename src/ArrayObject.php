<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{Collection, CollectionInterface};
use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};
use froq\common\exception\{AccessException, InvalidKeyException};
use froq\common\interface\{Arrayable, Listable, Jsonable, Collectable, Yieldable, Iteratable, IteratableReverse};
use froq\common\trait\ReadOnlyTrait;
use froq\util\Arrays;
use Countable, ArrayAccess, IteratorAggregate;

/**
 * Array Object.
 *
 * Represents a simple but very extended array-object structure (not like `ArrayObject`) that
 * does not use an internal array (like `ArrayObject$stroage`) with some utility methods.
 *
 * @package froq\collection
 * @object  froq\collection\ArrayObject
 * @author  Kerem Güneş
 * @since   5.14
 */
class ArrayObject implements Arrayable, Listable, Jsonable, Collectable, Yieldable, Iteratable, IteratableReverse,
    Countable, ArrayAccess, IteratorAggregate
{
    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /**
     * Constructor.
     *
     * @param object|iterable|null $data
     * @param bool|null            $readOnly
     */
    public function __construct(object|iterable $data = null, bool $readOnly = null)
    {
        if ($data != null) {
            $this->setData($data);
        }

        $this->readOnly($readOnly);
    }

    /** @magic serialize */
    public function __serialize(): array
    {
        return $this->toArray();
    }

    /** @magic un-serialize */
    public function __unserialize(array $data): void
    {
        // No setData() call here, cos' of readOnly state.
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Set data.
     *
     * @param  object|iterable $data
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function setData(object|iterable $data): self
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Get data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->toArray();
    }

    /**
     * Check whether given key has value.
     *
     * @param  int|string $key
     * @return bool
     */
    public function has(int|string $key): bool
    {
        return $this->isPropertyValid($key);
    }

    /**
     * Check whether given key exists.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        foreach ($this->toArray() as $thisKey => $_) {
            if ($key === $thisKey
                && $this->isPropertyValid($thisKey)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check whether given value exists.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return bool
     */
    public function hasValue(mixed $value, bool $strict = true): bool
    {
        foreach ($this->toArray() as $thisKey => $thisValue) {
            if (($strict ? $value === $thisValue : $value == $thisValue)
                && $this->isPropertyValid($thisKey)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Set a property.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     * @throws froq\common\exception\AccessException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function set(int|string $key, mixed $value): self
    {
        $this->readOnlyCheck();

        if (!$this->isPropertyAccessible($key)) {
            throw new AccessException(
                'Cannot set `%s` property, it is static or non-public', $key
            );
        }

        $this->{$key} = $value;

        return $this;
    }

    /**
     * Get a property.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed|null
     * @throws froq\common\exception\AccessException
     */
    public function get(int|string $key, mixed $default = null): mixed
    {
        if (!$this->isPropertyAccessible($key)) {
            throw new AccessException(
                'Cannot get `%s` property, it is static or non-public', $key
            );
        }

        return $this->{$key} ?? $default;
    }

    /**
     * Remove a property.
     *
     * @param  int|string $key
     * @return self
     * @throws froq\common\exception\AccessException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function remove(int|string $key): self
    {
        $this->readOnlyCheck();

        if (!$this->isPropertyAccessible($key)) {
            throw new AccessException(
                'Cannot remove `%s` property, it is static or non-public', $key
            );
        }

        unset($this->{$key});

        return $this;
    }

    /**
     * Get object property keys.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->toArray());
    }

    /**
     * Get object property values.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->toArray());
    }

    /**
     * Get object property entries.
     *
     * @return array
     */
    public function entries(): array
    {
        return array_entries($this->toArray());
    }

    /**
     * Run given callable for each property.
     *
     * @param  callable $func
     * @return self
     */
    public function each(callable $func): self
    {
        each($this->toArray(), $func);

        return $this;
    }

    /**
     * Empty properties.
     *
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function empty(): self
    {
        foreach ($this->keys() as $key) {
            $this->remove($key);
        }

        return $this;
    }

    /**
     * Check whether properties are empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return is_empty($this);
    }

    /**
     * Get properties as list.
     *
     * @return array
     */
    public function list(): array
    {
        return array_values($this->toArray());
    }

    /**
     * Check whether properties are list.
     *
     * @return bool
     */
    public function isList(): bool
    {
        return is_list($this->toArray());
    }

    /** Inherits. */

    /** @inheritDoc froq\common\interface\Arrayable */
    public function toArray(): array
    {
        foreach (get_object_vars($this) as $key => $value) {
            if ($this->isPropertyValid($key)) {
                $ret[$key] = $value;
            }
        }

        return $ret ?? [];
    }

    /** @inheritDoc froq\common\interface\Listable */
    public function toList(): array
    {
        return $this->list();
    }

    /** @inheritDoc froq\common\interface\Jsonable */
    public function toJson(int $flags = 0): string
    {
        return json_encode($this, $flags);
    }

    /** @inheritDoc froq\common\interface\Collectable */
    public function toCollection(): CollectionInterface
    {
        return new Collection($this->toArray());
    }

    /** @inheritDoc froq\common\interface\Yieldable */
    public function yield(): iterable
    {
        foreach ($this->toArray() as $key => $value) {
            yield $key => $value;
        }
    }

    /** @inheritDoc Countable */
    public function count(): int
    {
        return count($this->keys());
    }

    /** @inheritDoc ArrayAccess */
    public function offsetExists($key)
    {
        return $this->has($key);
    }
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }
    public function offsetGet($key)
    {
        return $this->get($key);
    }
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /** @inheritDoc Iteratable */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->toArray());
    }

    /** @inheritDoc IteratableReverse */
    public function getReverseIterator(): iterable
    {
        return new ReverseArrayIterator($this->toArray());
    }

    /** Filter, map, reduce stuff.  */

    /**
     * Apply a filter action on object properties.
     *
     * @param  callable|null $func
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function filter(callable $func = null): self
    {
        $data = Arrays::filter($this->toArray(), $func);

        return $this->empty()->setData($data);
    }

    /**
     * Apply a map action on object properties.
     *
     * @param  callable $func
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function map(callable $func): self
    {
        $data = Arrays::map($this->toArray(), $func);

        return $this->empty()->setData($data);
    }

    /**
     * Apply a reduce action on object properties.
     *
     * @param  mixed    $carry
     * @param  callable $func
     * @return self
     */
    public function reduce(mixed $carry, callable $func): mixed
    {
        return Arrays::reduce($this->toArray(), $carry, $func);
    }

    /** Sort stuff. */

    /**
     * Apply a sort objects properties.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @param  bool              $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sort(callable|int $func = null, $flags = 0, bool $keepKeys = true): self
    {
        $data = Arrays::sort($this->toArray(), $func, $flags, $keepKeys);

        return $this->empty()->setData($data);
    }

    /**
     * Apply a key sort objects properties.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortKey(callable $func = null, int $flags = 0): self
    {
        $data = Arrays::sortKey($this->toArray(), $func, $flags);

        return $this->empty()->setData($data);
    }

    /**
     * Apply a locale sort objects properties.
     *
     * @param  string|null $locale
     * @param  bool        $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortLocale(string $locale = null, bool $keepKeys = true): self
    {
        $data = Arrays::sortLocale($this->toArray(), $locale, $keepKeys);

        return $this->empty()->setData($data);
    }

    /**
     * Apply a natural sort objects properties.
     *
     * @param  bool $icase
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortNatural(bool $icase = false): self
    {
        $data = Arrays::sortNatural($this->toArray(), $icase);

        return $this->empty()->setData($data);
    }

    /** Static stuff. */

    /**
     * Create an instance with given data.
     *
     * @param  object|iterable $data
     * @return static
     */
    public static function from(object|iterable $data): static
    {
        return new static($data);
    }

    /** Property stuff. */

    /**
     * Check a property validity (public & non-static).
     *
     * @param  int|string  $key
     * @param  mixed|null &$value
     * @param  bool        $fillValue
     * @return bool
     * @throws froq\common\exception\InvalidKeyException
     */
    protected function isPropertyValid(int|string $key, mixed &$value = null, bool $fillValue = false): bool
    {
        if ($key == '') throw new InvalidKeyException(
            'Property key must be a non-empty int|string key, empty given'
        );

        // Numeric properties (a bit cheap for check).
        if (is_numeric($key)) {
            if (isset($this->{$key})) {
                $fillValue && ($value = $this->{$key});
                return true;
            }
        }

        // String/regular properties (a bit expensive for check).
        elseif (is_property($this, $key, ref: $ref)) {
            if ($ref?->isPublic() && !$ref->isStatic()) {
                $fillValue && ($value = $this->{$key});
                return true;
            }
        }

        return false;
    }

    /**
     * Check a property accessibility (public & non-static & non-exists).
     *
     * @param  int|string $key
     * @return bool
     */
    protected function isPropertyAccessible(int|string $key): bool
    {
        $ref = null;

        if (is_numeric($key) || !is_property($this, $key, ref: $ref)) {
            return true;
        }

        return $ref?->isPublic() && !$ref->isStatic();
    }
}

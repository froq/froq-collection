<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};

/**
 * Array Trait.
 *
 * A trait, provides some basic methods for array-like classes.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ArrayTrait
 * @author  Kerem Güneş
 * @since   4.0, 6.0
 */
trait ArrayTrait
{
    /** @see froq\collection\trait\*Trait */
    use SortTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait,
        EachTrait, CountTrait, EmptyTrait, FindTrait, MinMaxTrait, FirstLastTrait,
        CalcAverageTrait, CalcProductTrait, CalcSumTrait, IteratorTrait,
        ToArrayTrait, ToJsonTrait, ToListTrait, ToObjectTrait;

    /** @magic */
    public function __serialize(): array
    {
        return $this->data;
    }

    /** @magic */
    public function __unserialize(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Copy.
     *
     * @return static
     */
    public function copy(): static
    {
        return new static($this->data);
    }

    /**
     * Copy to.
     *
     * @param  self (static) $that
     * @return static
     */
    public function copyTo(self $that): static
    {
        $that->data = $this->data;

        return $that;
    }

    /**
     * Copy from.
     *
     * @param  self (static) $that
     * @return static
     */
    public function copyFrom(self $that): static
    {
        $this->data = $that->data;

        return $this;
    }

    /**
     * Get keys of data array.
     *
     * @return array<int|string>
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get values of data array.
     *
     * @return array<any>
     */
    public function values(): array
    {
        return array_values($this->data);
    }

    /**
     * Get entries of data array.
     *
     * @return array<array>
     * @since  5.0
     */
    public function entries(): array
    {
        return array_entries($this->data);
    }

    /**
     * Check whether data array contains given value/values.
     *
     * @param  mixed    $value
     * @param  mixed ...$values
     * @return bool
     * @since  5.0
     */
    public function contains(mixed $value, mixed ...$values): bool
    {
        return array_contains($this->data, $value, ...$values);
    }

    /**
     * Check whether data array contains given key/keys.
     *
     * @param  int|string    $key
     * @param  int|string ...$keys
     * @return bool
     * @since  5.0
     */
    public function containsKey(int|string $key, int|string ...$keys): bool
    {
        return array_contains_key($this->data, $key, ...$keys);
    }

    /**
     * @inheritDoc froq\common\interface\Yieldable
     * @since 5.4
     */
    public function yield(bool $reverse = false): iterable
    {
        if (!$reverse) {
            foreach ($this->data as $key => $value) {
                yield $key => $value;
            }
        } else {
            for (end($this->data); ($key = key($this->data)) !== null; prev($this->data)) {
                yield $key => current($this->data);
            }
        }
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc Iteratable
     */
    public function getIterator(): iterable
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @inheritDoc IteratableReverse
     */
    public function getReverseIterator(): iterable
    {
        return new ReverseArrayIterator($this->data);
    }

    /**
     * Static constructor.
     *
     * @param  iterable|null $data
     * @return static
     */
    public static function from(iterable|null $data): static
    {
        return new static($data);
    }

    /**
     * Static constructor from given keys (and value optionally).
     *
     * @param  array      $keys
     * @param  mixed|null $value
     * @return static
     * @since  5.14
     */
    public static function fromKeys(array $keys, mixed $value = null): static
    {
        return new static(array_fill_keys($keys, $value));
    }
}

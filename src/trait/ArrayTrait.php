<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\collection\iterator\{ArrayIterator, ReverseArrayIterator};

/**
 * A trait, provides some basic methods for array-like classes.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ArrayTrait
 * @author  Kerem Güneş
 * @since   4.0, 6.0
 */
trait ArrayTrait
{
    use SortTrait, FilterTrait, MapTrait, ReduceTrait, ApplyTrait, AggregateTrait,
        EachTrait, CountTrait, EmptyTrait, FindTrait, MinMaxTrait, FirstLastTrait,
        CalcAvgTrait, CalcSumTrait, IteratorTrait,
        ToArrayTrait, ToListTrait, ToObjectTrait, ToJsonTrait;

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
        return clone $this;
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
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get values of data array.
     *
     * @return array
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
     * Check whether data array contains any of given values.
     *
     * @param  mixed ...$values
     * @return bool
     * @since  5.0
     */
    public function contains(mixed ...$values): bool
    {
        return array_contains($this->data, ...$values);
    }

    /**
     * Check whether data array contains any of given keys.
     *
     * @param  int|string ...$keys
     * @return bool
     * @since  5.0
     */
    public function containsKey(int|string ...$keys): bool
    {
        return array_contains_key($this->data, ...$keys);
    }

    /**
     * Search for the key of given value.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @param  bool  $last
     * @return int|string|null
     */
    public function search(mixed $value, bool $strict = true, bool $last = false): int|string|null
    {
        return array_search_key($this->data, $value, $strict, $last);
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
     * @param  iterable $data
     * @return static
     */
    public static function from(iterable $data): static
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

<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\common\interface\{Arrayable, Jsonable};
use froq\util\Arrays;
use Iterator as _Iterator, Countable, Traversable;

/**
 * Iterator.
 *
 * Represents an iterator class entity that contains some utility methods.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\Iterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class Iterator implements _Iterator, Countable, Arrayable, Jsonable
{
    /** @var array */
    protected array $data;

    /**
     * Constructor.
     *
     * @param iterable $data
     */
    public function __construct(iterable $data)
    {
        if ($data instanceof Traversable) {
            $data = iterator_to_array($data);
        }

        $this->data = $data;
    }

    /**
     * Check whether a value exists in data stack.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return bool
     */
    public function has(mixed $value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Check whether a key exists in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Append a value to data stack.
     *
     * @param  mixed $value
     * @return self
     */
    public function append(mixed $value): self
    {
        $this->data[] = $value;

        return $this;
    }

    /**
     * Append a value to data stack with given key.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     */
    public function appendAt(int|string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /** @inheritDoc Iterator */
    public function current(): mixed
    {
        return current($this->data);
    }

    /** @inheritDoc Iterator */
    public function next(): void
    {
        next($this->data);
    }

    /** @inheritDoc Iterator */
    public function rewind(): void
    {
        reset($this->data);
    }

    /** @inheritDoc Iterator */
    public function key(): int|string|null
    {
        return key($this->data);
    }

    /** @alias of current() */
    public function value()
    {
        return $this->current();
    }

    /** @inheritDoc Iterator */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /** @alias of rewind() */
    public function reset()
    {
        $this->rewind();
    }

    /**
     * Empty data stack.
     *
     * @return self
     */
    public function empty(): self
    {
        $this->data = [];

        return $this;
    }

    /**
     * Check whether data stack is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Check whether data stack is a list.
     *
     * @return bool
     */
    public function isList(): bool
    {
        return is_list($this->data);
    }

    /**
     * Filter.
     *
     * @param  callable|null $func
     * @param  bool          $keepKeys
     * @return self
     */
    public function filter(callable $func = null, bool $keepKeys = true): self
    {
        $this->data = Arrays::filter($this->data, $func, $keepKeys);

        return $this;
    }

    /**
     * Map.
     *
     * @param  callable $func
     * @param  bool     $keepKeys
     * @return self
     */
    public function map(callable $func, bool $keepKeys = true): self
    {
        $this->data = Arrays::map($this->data, $func, $keepKeys);

        return $this;
    }

    /**
     * Reduce.
     *
     * @param  mixed    $carry
     * @param  callable $func
     * @return mixed
     */
    public function reduce(mixed $carry, callable $func): mixed
    {
        return Arrays::reduce($this->data, $carry, $func);
    }

    /**
     * Sort.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @param  bool          $keepKeys
     * @return self
     */
    public function sort(callable $func = null, int $flags = 0, bool $keepKeys = true): self
    {
        $this->data = Arrays::sort($this->data, $func, $flags, $keepKeys);

        return $this;
    }

    /**
     * Sort key.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @return self
     */
    public function sortKey(callable $func = null, int $flags = 0): self
    {
        $this->data = Arrays::sortKey($this->data, $func, $flags);

        return $this;
    }

    /**
     * @inheritDoc Countable
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc froq\common\interface\Jsonable
     */
    public function toJson(int $flags = 0): string
    {
        return (string) json_encode($this->data, $flags);
    }
}

<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\common\interface\{Arrayable, Jsonable};
use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, ReadOnlyTrait};
use froq\util\Arrays;
use Iterator as _Iterator, Countable, Traversable;

/**
 * Iterator.
 *
 * Represents an iterator class that contains some utility methods.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\Iterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class Iterator implements _Iterator, Arrayable, Jsonable, Countable
{
    /** @see froq\collection\trait\SortTrait */
    /** @see froq\collection\trait\EachTrait */
    /** @see froq\collection\trait\FilterTrait */
    /** @see froq\collection\trait\MapTrait */
    /** @see froq\collection\trait\ReduceTrait */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait;

    /** @see froq\collection\trait\ReadOnlyTrait @since 5.5 */
    use ReadOnlyTrait;

    /** @var array */
    protected array $data;

    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     */
    public function __construct(iterable $data, bool $readOnly = null)
    {
        if ($data instanceof Traversable) {
            $data = iterator_to_array($data);
        }

        $this->data = $data;

        $this->readOnly($readOnly);
    }

    /**
     * Check whether a value exists in data array.
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
     * Check whether a key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Append a value to data array.
     *
     * @param  mixed $value
     * @return self
     */
    public function append(mixed $value): self
    {
        $this->readOnlyCheck();

        $this->data[] = $value;

        return $this;
    }

    /**
     * Append a value to data array with given key.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     */
    public function appendAt(int|string $key, mixed $value): self
    {
        $this->readOnlyCheck();

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

    /** @inheritDoc Iterator */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /** @alias of current() */
    public function value()
    {
        return $this->current();
    }

    /** @alias of rewind() */
    public function reset()
    {
        $this->rewind();
    }

    /**
     * Reverse data array.
     *
     * @param  bool $keepKeys
     * @return self
     * @since  5.5
     */
    public function reverse(bool $keepKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_reverse($this->data, $keepKeys);

        return $this;
    }

    /**
     * Empty data array.
     *
     * @return self
     */
    public function empty(): self
    {
        $this->readOnlyCheck();

        $this->data = [];

        return $this;
    }

    /**
     * Check whether data array is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Check whether data array is a list.
     *
     * @return bool
     */
    public function isList(): bool
    {
        return is_list($this->data);
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

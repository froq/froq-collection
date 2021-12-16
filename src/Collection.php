<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AbstractCollection;
use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetAsTrait, HasTrait};
use froq\util\Arrays;
use ArrayAccess;

/**
 * Collection.
 *
 * Represents a collection entity that contains a bunch of utility methods and behaves like a simple
 * object.
 *
 * @package froq\collection
 * @object  froq\collection\Collection
 * @author  Kerem Güneş
 * @since   1.0
 */
class Collection extends AbstractCollection implements ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\AccessMagicTrait
     * @see froq\collection\trait\GetAsTrait
     * @see froq\collection\trait\HasTrait
     * @since 4.0, 5.0, 5.15
     */
    use AccessTrait, AccessMagicTrait, GetAsTrait, HasTrait;

    /**
     * Constructor.
     *
     * @param array<int|string, any>|null $data
     * @param bool|null                   $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Set an item/items.
     *
     * @param  int|string|array<int|string> $key
     * @param  any|null                     $value
     * @return self
     */
    public function set(int|string|array $key, $value = null): self
    {
        $this->readOnlyCheck();

        is_array($key) ? Arrays::setAll($this->data, $key)
                       : Arrays::set($this->data, $key, $value);

        return $this;
    }

    /**
     * Get an item/items.
     *
     * @param  int|string|array<int|string> $key
     * @param  any|null                     $default
     * @return any|null
     */
    public function get(int|string|array $key, $default = null)
    {
        return is_array($key) ? Arrays::getAll($this->data, $key, $default)
                              : Arrays::get($this->data, $key, $default);
    }

    /**
     * Pull an item/items.
     *
     * @param  int|string|array<int|string> $key
     * @param  any|null                     $default
     * @return any|null
     * @since  3.0
     */
    public function pull(int|string|array $key, $default = null)
    {
        $this->readOnlyCheck();

        return is_array($key) ? Arrays::pullAll($this->data, $key, $default)
                              : Arrays::pull($this->data, $key, $default);
    }

    /**
     * Add (append) an item/items.
     *
     * @param  any  ...$value
     * @return self
     * @throws froq\collection\CollectionException
     * @since  3.0
     */
    public function add(...$values): self
    {
        $this->readOnlyCheck();

        $values || throw new CollectionException('No value(s) provided');

        foreach ($values as $value) {
            $this->data[] = $value;
        }

        return $this;
    }

    /**
     * Remove an item/items.
     *
     * @param  int|string|array<int|string> $key
     * @return self
     */
    public function remove(int|string|array $key): self
    {
        $this->readOnlyCheck();

        Arrays::removeAll($this->data, (array) $key);

        return $this;
    }

    /**
     * Compact given key(s) with value(s).
     *
     * @param  int|string|array     $key
     * @param  mixed            &...$value
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function compact(int|string|array $key, mixed ...$value): self
    {
        $this->readOnlyCheck();

        $value || throw new CollectionException('No value(s) provided');

        foreach ((array) $key as $i => $key) {
            $this->data[$key] = $value[$i] ?? null;
        }

        return $this;
    }

    /**
     * Extract given key(s) onto value(s) with ref(s).
     *
     * @param  int|string|array     $key
     * @param  mixed            &...$value
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function extract(int|string|array $key, mixed &...$value): self
    {
        $value || throw new CollectionException('No value(s) provided');

        foreach ((array) $key as $i => $key) {
            $value[$i] = $this->data[$key] ?? null;
        }

        return $this;
    }

    /**
     * Push an item.
     *
     * @param  any $value
     * @return self
     * @since  5.11
     */
    public function push($value): self
    {
        $this->readOnlyCheck();

        array_push($this->data, $value);

        return $this;
    }

    /**
     * Pop an item.
     *
     * @return any
     * @since  4.0
     */
    public function pop()
    {
        $this->readOnlyCheck();

        return array_pop($this->data);
    }

    /**
     * Unpop an item (aka push).
     *
     * @param  array<int|string, any> $data
     * @return self
     * @since  4.0
     */
    public function unpop(array $data): self
    {
        $this->readOnlyCheck();

        foreach ($data as $key => $value) {
            // Drop olds, so prevent in-place replace.
            if (isset($this->data[$key])) {
                unset($this->data[$key]);
            }
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Shift an item.
     *
     * @return any
     * @since  4.0
     */
    public function shift()
    {
        $this->readOnlyCheck();

        return array_shift($this->data);
    }

    /**
     * Unshift an item.
     *
     * @param  array<int|string, any> $data
     * @return self
     * @since  4.0
     */
    public function unshift(array $data): self
    {
        $this->readOnlyCheck();

        $this->data = $data + $this->data;

        return $this;
    }

    /**
     * Append given values to data array.
     *
     * @param  ... $values
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function append(...$values): self
    {
        $this->readOnlyCheck();

        $values || throw new CollectionException('No value(s) provided');

        $this->data = array_append($this->data, ...$values);

        return $this;
    }

    /**
     * Prepend given values to data array.
     *
     * @param  ... $values
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function prepend(...$values): self
    {
        $this->readOnlyCheck();

        $values || throw new CollectionException('No value(s) provided');

        $this->data = array_prepend($this->data, ...$values);

        return $this;
    }

    /**
     * Reverse data array.
     *
     * @param  bool $keepKeys
     * @return self
     * @since  4.0
     */
    public function reverse(bool $keepKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_reverse($this->data, $keepKeys);

        return $this;
    }

    /**
     * Pad data array by given length.
     *
     * @param  int      $length
     * @param  any|null $value
     * @return self
     * @since  5.0
     */
    public function pad(int $length, $value = null): self
    {
        $this->readOnlyCheck();

        $this->data = array_pad($this->data, $length, $value);

        return $this;
    }

    /**
     * Pad data array by given keys if not set on.
     *
     * @param  array    $keys
     * @param  any|null $value
     * @return self
     * @since  5.0
     */
    public function padKeys(array $keys, $value = null): self
    {
        $this->readOnlyCheck();

        $this->data = array_pad_keys($this->data, $keys, $value);

        return $this;
    }

    /**
     * Select an item/items from data array by given key(s).
     *
     * @param  int|string|array<int|string> $key
     * @param  bool                         $combine (AKA keep-keys directive).
     * @return static
     * @since  5.0
     */
    public function select(int|string|array $key, bool $combine = true): static
    {
        $data = array_select($this->data, $key, combine: $combine);

        return new static((array) $data);
    }

    /**
     * Select item columns from data array by given key, optionally index by given index key.
     *
     * @param  int|string      $key
     * @param  int|string|null $indexKey
     * @return static
     * @since  5.0
     */
    public function selectColumn(int|string $key, int|string $indexKey = null): static
    {
        $data = array_column($this->data, $key, $indexKey);

        return new static($data);
    }

    /**
     * @alias of selectColumn()
     */
    public function column(...$args)
    {
        return $this->selectColumn(...$args);
    }

    /**
     * Index items in data array by given index key, optionally select columns only by given key.
     *
     * @param  int|string      $indexKey
     * @param  int|string|null $key
     * @return static
     * @since  5.5
     */
    public function indexColumn(int|string $indexKey, int|string $key = null): static
    {
        $data = array_column($this->data, $key, $indexKey);

        return new static($data);
    }

    /**
     * @alias of indexColumn()
     * @since 5.5
     */
    public function index(...$args)
    {
        return $this->indexColumn(...$args);
    }

    /**
     * Delete an item/items from data array by given value(s).
     *
     * @param  ... $values
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function delete(...$values): self
    {
        $this->readOnlyCheck();

        $values || throw new CollectionException('No value(s) provided');

        $this->data = array_delete($this->data, ...$values);

        return $this;
    }

    /**
     * Gather mutual items from given data array over own data array.
     *
     * @param  ... $datas
     * @return static
     * @since  5.0
     */
    public function mutual(...$datas): static
    {
        $data = array_intersect($this->data, ...$datas);

        return new static($data);
    }

    /**
     * Gather unmutual items from given data array over own data array.
     *
     * @param  ... $datas
     * @return static
     * @since  5.0
     */
    public function unmutual(...$datas): static
    {
        $data = array_diff($this->data, ...$datas);

        return new static($data);
    }

    /**
     * Get unique items from data array.
     *
     * @return static
     * @since  4.0
     */
    public function unique(): static
    {
        $data = array_unique($this->data, SORT_REGULAR);

        return new static($data);
    }

    /**
     * @alias of unique()
     */
    public function uniq()
    {
        return $this->unique();
    }

    /**
     * Slice data array.
     *
     * @param  int      $start
     * @param  int|null $end
     * @param  bool     $keepKeys
     * @return static
     * @since  4.0
     */
    public function slice(int $start, int $end = null, bool $keepKeys = false): static
    {
        $data = array_slice($this->data, $start, $end, $keepKeys);

        return new static($data);
    }

    /**
     * Split data array.
     *
     * @param  int  $limit
     * @param  bool $keepKeys
     * @return static
     * @since  4.0
     */
    public function split(int $limit, bool $keepKeys = false): static
    {
        $data = array_chunk($this->data, $limit, $keepKeys);

        return new static($data);
    }

    /**
     * Join all items with given delimiter.
     *
     * @param  string $glue
     * @return string
     * @since  4.0
     */
    public function join(string $glue): string
    {
        return join($glue, $this->data);
    }

    /**
     * Merge data array with given data array.
     *
     * @param  array ...$datas
     * @return self
     * @throws froq\collection\CollectionException
     * @since  4.0
     */
    public function merge(array ...$datas): self
    {
        $this->readOnlyCheck();

        $datas || throw new CollectionException('No data(s) provided');

        $this->data = array_merge($this->data, ...$datas);

        return $this;
    }

    /**
     * Replace data array with given data array.
     *
     * @param  array ...$datas
     * @return self
     * @throws froq\collection\CollectionException
     * @since  5.0
     */
    public function replace(array ...$datas): self
    {
        $this->readOnlyCheck();

        $datas || throw new CollectionException('No data(s) provided');

        $this->data = array_replace($this->data, ...$datas);

        return $this;
    }

    /**
     * Flat data array.
     *
     * @param  bool $useKeys
     * @param  bool $fixKeys
     * @param  bool $multi
     * @return self
     * @since  4.0
     */
    public function flat(bool $useKeys = false, bool $fixKeys = false, bool $multi = true): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::flat($this->data, $useKeys, $fixKeys, $multi);

        return $this;
    }

    /**
     * Sweep data array dropping empty items those null, '' or [].
     *
     * @param  array|null $ignoredKeys
     * @return self
     * @since  4.0
     */
    public function sweep(array $ignoredKeys = null): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::sweep($this->data, $ignoredKeys);

        return $this;
    }

    /**
     * Search given value returning value's hit count.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return int
     * @since  4.0
     */
    public function search($value, bool $strict = true): int
    {
        return Arrays::search($this->data, $value, $strict);
    }

    /**
     * Search given value's key.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return int|string|null
     * @since  5.2
     */
    public function searchKey($value, bool $strict = true): int|string|null
    {
        return Arrays::searchKey($this->data, $value, $strict);
    }

    /**
     * Search given value's last key.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return int|string|null
     * @since  5.5
     */
    public function searchLastKey($value, bool $strict = true): int|string|null
    {
        return Arrays::searchLastKey($this->data, $value, $strict);
    }

    /**
     * @alias of searchKey()
     * @since 5.5
     */
    public function indexOf(...$args)
    {
        return $this->searchKey(...$args);
    }

    /**
     * @alias of searchLastKey()
     * @since 5.5
     */
    public function lastIndexOf(...$args)
    {
        return $this->searchLastKey(...$args);
    }

    /**
     * Test, like JavaScript Array.some().
     *
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function test(callable $func): bool
    {
        return Arrays::test($this->data, $func);
    }

    /**
     * Test all, like JavaScript Array.every().
     *
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function testAll(callable $func): bool
    {
        return Arrays::testAll($this->data, $func);
    }

    /**
     * Find, like JavaScript Array.find().
     *
     * @param  callable $func
     * @return any|null
     * @since  4.3
     */
    public function find(callable $func)
    {
        return Arrays::find($this->data, $func);
    }

    /**
     * Find all, kinda filter.
     *
     * @param  callable $func
     * @param  bool     $useKeys
     * @return array
     * @since  4.3
     */
    public function findAll(callable $func, bool $useKeys = false): array
    {
        return Arrays::findAll($this->data, $func, $useKeys);
    }

    /**
     * Randomize data array returning [key,value] pairs.
     *
     * @param  int  $limit
     * @param  bool $pack
     * @return any|null
     * @since  4.0
     */
    public function random(int $limit = 1, bool $pack = false)
    {
        return Arrays::random($this->data, $limit, $pack);
    }

    /**
     * Shuffle data array.
     *
     * @param  bool $assoc
     * @return self
     * @since  4.0
     */
    public function shuffle(bool $assoc = false)
    {
        $this->readOnlyCheck();

        Arrays::shuffle($this->data, $assoc);

        return $this;
    }

    /**
     * Flip data array.
     *
     * @return self
     * @since  4.0
     */
    public function flip(): self
    {
        $this->readOnlyCheck();

        $this->data = array_flip($this->data);

        return $this;
    }

    /**
     * Fill data array with given value.
     *
     * @param  any $value
     * @return self
     * @since  4.0
     */
    public function fill($value): self
    {
        $this->readOnlyCheck();

        $this->data = array_fill_keys(array_keys($this->data), $value);

        return $this;
    }

    /**
     * Fill data array with given keys & value.
     *
     * @param  array<int|string> $keys
     * @param  any               $value
     * @return self
     * @since  5.0
     */
    public function fillKeys(array $keys, $value): self
    {
        $this->readOnlyCheck();

        $this->data = array_fill_keys($keys, $value);

        return $this;
    }

    /**
     * Get an item from data array with given key.
     *
     * @param  int|string $key
     * @return any
     */
    public function item(int|string $key)
    {
        return $this->get($key);
    }

    /**
     * Get all items from data array with/without given keys.
     *
     * @param  array<int|string>|null $keys
     * @return array
     */
    public function items(array $keys = null): array
    {
        if ($keys == null) {
            return $this->data;
        }

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->get($key);
        }
        return $items;
    }

    /**
     * Get first item or return null if no items on data array.
     *
     * @return any|null
     * @since  4.0
     */
    public function first()
    {
        return array_first($this->data);
    }

    /**
     * Find first key or return null if no items data array.
     *
     * @return int|string|null
     * @since  4.0
     */
    public function firstKey(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Get last item or return null if no items on data array.
     *
     * @return any|null
     * @since  4.0
     */
    public function last()
    {
        return array_last($this->data);
    }

    /**
     * Find last key or return null if no items data array.
     *
     * @return int|string|null
     * @since  4.0
     */
    public function lastKey(): int|string|null
    {
        return array_key_last($this->data);
    }
}

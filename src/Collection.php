<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException, AccessTrait, AccessMagicTrait};
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
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /**
     * Constructor.
     *
     * @param array<int|string, any>|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    /**
     * Check whether an item set in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public function has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether a key/index exists in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check with/without strict mode whether data stack has given value.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public function hasValue($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Put an item/items into data stack.
     *
     * @param  int|string|array<int|string>|null $key
     * @param  any|null                          $value
     * @return self
     */
    public function set(int|string|array $key, $value = null): self
    {
        $this->readOnlyCheck();

        if ($key === null) { // From conventions like: $a[] = 1.
            $this->data[] = $value;
        } else {
            is_array($key) ? Arrays::setAll($this->data, $key)
                           : Arrays::set($this->data, $key, $value);
        }

        return $this;
    }

    /**
     * Get an item/items from data stack.
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
     * Pull an item/items from data stack.
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
     * Add (append) an item to data stack, flat if already exists.
     *
     * @param  int|string|array<int|string, any> $key
     * @param  any|null                          $value
     * @return self
     * @since  3.0
     */
    public function add(int|string|array $key, $value = null): self
    {
        $this->readOnlyCheck();

        @ [$key, $value] = is_array($key) ? $key : [$key, $value];

        if (isset($this->data[$key])) {
            $this->data[$key] = Arrays::flat([$this->data[$key], $value]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Remove an item/items from data stack.
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
     * @param  int|string|array  $key
     * @param  ...               $value
     * @return self
     * @since  5.0
     */
    public function compact(int|string|array $key, ...$value): self
    {
        foreach ((array) $key as $i => $key) {
            $this->data[$key] = $value[$i] ?? null;
        }

        return $this;
    }

    /**
     * Extract given key(s) onto value(s) with ref(s).
     *
     * @param  int|string|array  $key
     * @param  ...               $value
     * @return self
     * @since  5.0
     */
    public function extract(int|string|array $key, &...$value): self
    {
        foreach ((array) $key as $i => $key) {
            $value[$i] = $this->data[$key] ?? null;
        }

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
     * Append given values to data stack.
     *
     * @param  ... $values
     * @return self
     * @since  5.0
     */
    public function append(...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_append($this->data, ...$values);

        return $this;
    }

    /**
     * Prepend given values to data stack.
     *
     * @param  ... $values
     * @return self
     * @since  5.0
     */
    public function prepend(...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_prepend($this->data, ...$values);

        return $this;
    }

    /**
     * Reverse data stack.
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
     * Pad data stack by given length.
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
     * Pad data stack by given keys if not set on.
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
     * Select an item/items from data stack by given key(s).
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
     * Select item columns from data stack by given key, optionally index by given index argument.
     *
     * @param  int|string      $key
     * @param  int|string|null $index
     * @return static
     * @since  5.0
     */
    public function selectColumn(int|string $key, int|string $index = null): static
    {
        $data = array_column($this->data, $key, $index);

        return new static((array) $data);
    }

    /**
     * @alias of selectColumn()
     */
    public function column(...$args)
    {
        return $this->selectColumn(...$args);
    }

    /**
     * Delete an item/items from data stack by given value(s).
     *
     * @param  ... $values
     * @return self
     * @since  5.0
     */
    public function delete(...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_delete($this->data, ...$values);

        return $this;
    }

    /**
     * Gather mutual items from given data stack over own data stack.
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
     * Gather unmutual items from given data stack over own data stack.
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
     * Get unique items from data stack.
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
     * Slice data stack.
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
     * Split data stack.
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
     * Merge data stack with given data stack.
     *
     * @param  array ...$datas
     * @return self
     * @since  4.0
     */
    public function merge(array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_merge($this->data, ...$datas);

        return $this;
    }

    /**
     * Replace data stack with given data stack.
     *
     * @param  array ...$datas
     * @return self
     * @since  5.0
     */
    public function replace(array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_replace($this->data, ...$datas);

        return $this;
    }

    /**
     * Flat data stack.
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
     * Sweep data stack dropping empty items those null, '' or [].
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
     * Search given value's key (works as self.index()).
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
     * Randomize data stack returning [key,value] pairs.
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
     * Shuffle data stack.
     *
     * @param  bool $keepKeys
     * @return self
     * @since  4.0
     */
    public function shuffle(bool $keepKeys = false)
    {
        $this->readOnlyCheck();

        Arrays::shuffle($this->data, $keepKeys);

        return $this;
    }

    /**
     * Flip data stack.
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
     * Fill data stack with given value.
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
     * Fill data stack with given keys & value.
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
     * Apply a sort on data stack.
     *
     * @param  string|null $func
     * @param  int         $flags
     * @param  bool        $keepKeys
     * @return self
     */
    public function sort(callable $func = null, $flags = 0, bool $keepKeys = true): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::sort($this->data, $func, $flags, $keepKeys);

        return $this;
    }

    /**
     * Apply a key sort on data stack.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @return self
     * @since  5.2
     */
    public function sortKey(callable $func = null, int $flags = 0): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::sortKey($this->data, $func, $flags);

        return $this;
    }

    /**
     * Apply a locale sort on data stack.
     *
     * @param  string|null $locale
     * @param  bool        $keepKeys
     * @return self
     * @since  4.0
     */
    public function sortLocale(string $locale = null, bool $keepKeys = true): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::sortLocale($this->data, $locale, $keepKeys);

        return $this;
    }

    /**
     * Apply a natural sort on data stack.
     *
     * @param  bool $icase
     * @return self
     * @since  4.0
     */
    public function sortNatural(bool $icase = false): self
    {
        $this->readOnlyCheck();

        $this->data = Arrays::sortNatural($this->data, $icase);

        return $this;
    }

    /**
     * Get an item from data stack with given key/index.
     *
     * @param  int|string $key
     * @return any
     */
    public function item(int|string $key)
    {
        return $this->get($key);
    }

    /**
     * Get all items from data stack with/without given keys.
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
     * @alias of index()
     * @since 5.0
     */
    public function key(...$args)
    {
        return $this->index(...$args);
    }

    /**
     * Find key/index of given value with/without strict mode.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return int|string|null
     * @since  4.0
     */
    public function index($value, bool $strict = true): int|string|null
    {
        return Arrays::index($this->data, $value, $strict);
    }

    /**
     * Get first item or return null if no items on data stack.
     *
     * @return any|null
     * @since  4.0
     */
    public function first()
    {
        return array_first($this->data);
    }

    /**
     * Find first key/index or return null if no items data stack.
     *
     * @return int|string|null
     * @since  4.0
     */
    public function firstKey(): int|string|null
    {
        return array_key_first($this->data);
    }

    /**
     * Get last item or return null if no items on data stack.
     *
     * @return any|null
     * @since  4.0
     */
    public function last()
    {
        return array_last($this->data);
    }

    /**
     * Find last key/index or return null if no items data stack.
     *
     * @return int|string|null
     * @since  4.0
     */
    public function lastKey(): int|string|null
    {
        return array_key_last($this->data);
    }
}

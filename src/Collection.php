<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait, HasTrait};

/**
 * Collection.
 *
 * A collection class, contains a couple of utility methods and behaves like a simple object.
 *
 * @package froq\collection
 * @object  froq\collection\Collection
 * @author  Kerem Güneş
 * @since   1.0
 */
class Collection extends AbstractCollection implements \ArrayAccess
{
    use AccessTrait, AccessMagicTrait, GetTrait, HasTrait;

    /**
     * Constructor.
     *
     * @param array|null $data
     * @param bool|null  $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Set one/many items.
     *
     * @param  int|string|array<int|string> $key
     * @param  mixed|null                   $value
     * @return self
     */
    public function set(int|string|array $key, mixed $value = null): self
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

        array_set($this->data, $key, $value);

        return $this;
    }

    /**
     * Get one/many items.
     *
     * @param  int|string|array<int|string> $key
     * @param  mixed|null                   $default
     * @param  bool                         $drop
     * @return mixed|null
     */
    public function get(int|string|array $key, mixed $default = null, bool $drop = false): mixed
    {
        $value = array_get($this->data, $key, $default, $drop);

        return $value;
    }

    /**
     * Remove one/many items.
     *
     * @param  int|string|array<int|string> $key
     * @return self
     */
    public function remove(int|string|array $key): self
    {
        $this->readOnlyCheck();

        array_remove($this->data, $key);

        return $this;
    }

    /**
     * Add (append) items.
     *
     * @param  mixed ...$values
     * @return self
     * @since  3.0
     */
    public function add(mixed ...$values): self
    {
        $this->readOnlyCheck();

        foreach ($values as $value) {
            $this->data[] = $value;
        }

        return $this;
    }

    /**
     * Compact given keys with given vars.
     *
     * @param  int|string|array $keys
     * @param  mixed            ...$vars
     * @return self
     * @since  5.0
     */
    public function compact(int|string|array $keys, mixed ...$vars): self
    {
        $this->readOnlyCheck();

        $this->data = array_compact($keys, ...$vars);

        return $this;
    }

    /**
     * Extract given keys to given vars with refs.
     *
     * @param  int|string|array $keys
     * @param  mixed            &...$vars
     * @return int
     * @since  5.0
     */
    public function extract(int|string|array $keys, mixed &...$vars): int
    {
        $ret = array_extract($this->data, $keys, ...$vars);

        return $ret;
    }

    /**
     * Push an item.
     *
     * @param  mixed $value
     * @return self
     * @since  5.11
     */
    public function push(mixed $value): self
    {
        $this->readOnlyCheck();

        array_push($this->data, $value);

        return $this;
    }

    /**
     * Pop an item.
     *
     * @return mixed
     * @since  4.0
     */
    public function pop(): mixed
    {
        $this->readOnlyCheck();

        return array_pop($this->data);
    }

    /**
     * Unpop an item (aka push).
     *
     * @param  array $data
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
     * @return mixed
     * @since  4.0
     */
    public function shift(): mixed
    {
        $this->readOnlyCheck();

        return array_shift($this->data);
    }

    /**
     * Unshift an item.
     *
     * @param  array $data
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
     * @param  mixed    $value
     * @param  mixed ...$values
     * @return self
     * @since  5.0
     */
    public function append(mixed $value, mixed ...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_append($this->data, $value, ...$values);

        return $this;
    }

    /**
     * Prepend given values to data array.
     *
     * @param  mixed    $value
     * @param  mixed ...$values
     * @return self
     * @since  5.0
     */
    public function prepend(mixed $value, mixed ...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_prepend($this->data, $value, ...$values);

        return $this;
    }

    /**
     * Delete one/many items by given value(s).
     *
     * @param  mixed    $value
     * @param  mixed ...$values
     * @return self
     * @since  5.0
     */
    public function delete(mixed $value, mixed ...$values): self
    {
        $this->readOnlyCheck();

        $this->data = array_delete($this->data, $value, ...$values);

        return $this;
    }

    /**
     * Delete one/many items by given key(s).
     *
     * @param  int|string    $key
     * @param  int|string ...$keys
     * @return self
     * @since  5.24
     */
    public function deleteKey(int|string $key, int|string ...$keys): self
    {
        $this->readOnlyCheck();

        $this->data = array_delete_key($this->data, $key, ...$keys);

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
     * Concat given item(s) with data array.
     *
     * @param  mixed    $item
     * @param  mixed ...$items
     * @return self
     * @since  5.22
     */
    public function concat(mixed $item, mixed ...$items): self
    {
        $this->readOnlyCheck();

        $this->data = array_concat($this->data, $item, ...$items);

        return $this;
    }

    /**
     * Union given data(s) with data array.
     *
     * @param  array    $data
     * @param  array ...$datas
     * @return self
     * @since  5.22
     */
    public function union(array $data, array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_union($this->data, $data, ...$datas);

        return $this;
    }

    /**
     * Dedupe items in data array.
     *
     * @param  bool $strict
     * @param  bool $list
     * @return self
     * @since  4.0
     */
    public function dedupe(bool $strict = true, bool $list = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_dedupe($this->data, $strict, $list);

        return $this;
    }

    /**
     * Use unique items in data array.
     *
     * @param  int $flags
     * @return self
     * @since  4.0
     */
    public function unique(int $flags = SORT_REGULAR): self
    {
        $this->readOnlyCheck();

        $this->data = array_unique($this->data, $flags);

        return $this;
    }

    /**
     * Select item(s) from data array by given key(s) & return a new static instance.
     *
     * @param  int|string|array<int|string> $key
     * @param  mixed|null                   $default
     * @param  bool                         $combine
     * @return static
     * @since  5.0
     */
    public function select(int|string|array $key, mixed $default = null, bool $combine = true): static
    {
        $data = (array) array_select($this->data, $key, $default, $combine);

        return new static($data);
    }

    /**
     * Select item columns from data array by given key, optionally index by given index key
     * & return a new static instance.
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
     * @alias selectColumn()
     */
    public function column(...$args)
    {
        return $this->selectColumn(...$args);
    }

    /**
     * Index items in data array by given index key, optionally select columns only by given key
     * & return a new static instance.
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
     * @alias indexColumn()
     * @since 5.5
     */
    public function index(...$args)
    {
        return $this->indexColumn(...$args);
    }

    /**
     * Slice data array & return a new static instance.
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
     * Chunk data array & return a new static instance.
     *
     * @param  int  $length
     * @param  bool $keepKeys
     * @return static
     * @since  4.0
     */
    public function chunk(int $length, bool $keepKeys = false): static
    {
        $data = array_chunk($this->data, $length, $keepKeys);

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
     * Merge data array with given data array(s).
     *
     * @param  array    $data
     * @param  array ...$datas
     * @return self
     * @since  4.0
     */
    public function merge(array $data, array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_merge($this->data, $data, ...$datas);

        return $this;
    }

    /**
     * Merge data array with given data array(s) recursively.
     *
     * @param  array    $data
     * @param  array ...$datas
     * @return self
     * @since  5.22
     */
    public function mergeRecursive(array $data, array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_merge_recursive($this->data, $data, ...$datas);

        return $this;
    }

    /**
     * Replace data array with given data array(s).
     *
     * @param  array    $data
     * @param  array ...$datas
     * @return self
     * @since  5.0
     */
    public function replace(array $data, array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_replace($this->data, $data, ...$datas);

        return $this;
    }

    /**
     * Replace data array with given data array(s) recursively.
     *
     * @param  array    $data
     * @param  array ...$datas
     * @return self
     * @since  5.22
     */
    public function replaceRecursive(array $data, array ...$datas): self
    {
        $this->readOnlyCheck();

        $this->data = array_replace_recursive($this->data, $data, ...$datas);

        return $this;
    }

    /**
     * Flat data array.
     *
     * @param  bool $keepKeys
     * @param  bool $fixKeys
     * @param  bool $multi
     * @return self
     * @since  4.0
     */
    public function flat(bool $keepKeys = false, bool $fixKeys = false, bool $multi = true): self
    {
        $this->readOnlyCheck();

        $this->data = array_flat($this->data, $keepKeys, $fixKeys, $multi);

        return $this;
    }

    /**
     * Clean data array dropping null, "", [] values.
     *
     * @param  bool       $keepKeys
     * @param  array|null $ignoredKeys
     * @return self
     * @since  4.0
     */
    public function clean(bool $keepKeys = true, array $ignoredKeys = null): self
    {
        $this->readOnlyCheck();

        $this->data = array_clean($this->data, $keepKeys, $ignoredKeys);

        return $this;
    }

    /**
     * Clear data array dropping given values.
     *
     * @param  array      $values
     * @param  bool       $keepKeys
     * @param  array|null $ignoredKeys
     * @return self
     * @since  6.0
     */
    public function clear(array $values, bool $keepKeys = true, array $ignoredKeys = null): self
    {
        $this->readOnlyCheck();

        $this->data = array_clear($this->data, $values, $keepKeys, $ignoredKeys);

        return $this;
    }

    /**
     * Search given value's key.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return int|string|null
     * @since  5.2
     */
    public function searchKey(mixed $value, bool $strict = true): int|string|null
    {
        return array_search_key($this->data, $value, $strict);
    }

    /**
     * Search given value's last key.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return int|string|null
     * @since  5.5
     */
    public function searchLastKey(mixed $value, bool $strict = true): int|string|null
    {
        return array_search_key($this->data, $value, $strict, true);
    }

    /**
     * @alias searchKey()
     * @since 5.5
     */
    public function indexOf(...$args)
    {
        return $this->searchKey(...$args);
    }

    /**
     * @alias searchLastKey()
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
        return array_test($this->data, $func);
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
        return array_test_all($this->data, $func);
    }

    /**
     * Randomize data array returning [key,value] pairs.
     *
     * @param  int  $limit
     * @param  bool $pack
     * @param  bool $drop
     * @return mixed|null
     * @since  4.0
     */
    public function random(int $limit = 1, bool $pack = false, bool $drop = false): mixed
    {
        return array_random($this->data, $limit, $pack, $drop);
    }

    /**
     * Shuffle data array.
     *
     * @param  bool|null $assoc
     * @return self
     * @since  4.0
     */
    public function shuffle(bool $assoc = null)
    {
        $this->readOnlyCheck();

        $this->data = array_shuffle($this->data, $assoc);

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
     * Pad data array by given length.
     *
     * @param  int        $length
     * @param  mixed|null $value
     * @param  bool       $append
     * @return self
     * @since  5.0
     */
    public function pad(int $length, mixed $value = null, bool $append = false): self
    {
        $this->readOnlyCheck();

        if (!$append) {
            $this->data = array_pad($this->data, $length, $value);
        } else {
            // Don't modify existing indexes.
            $length = abs($length);
            while ($length-- > 0) {
                $this->append($value);
            }
        }

        return $this;
    }

    /**
     * Pad data array by given keys if not set on.
     *
     * @param  array      $keys
     * @param  mixed|null $value
     * @param  bool       $isset
     * @return self
     * @since  5.0
     */
    public function padKeys(array $keys, mixed $value = null, bool $isset = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_pad_keys($this->data, $keys, $value, $isset);

        return $this;
    }

    /**
     * Fill data array with given value.
     *
     * @param  int|null   $length
     * @param  mixed|null $value
     * @param  bool       $append
     * @return self
     * @since  4.0
     */
    public function fill(int $length, mixed $value = null, bool $append = false): self
    {
        $this->readOnlyCheck();

        if (!$append) {
            $this->data = array_fill(0, $length, $value);
        } else {
            // Don't modify existing indexes.
            $length = abs($length);
            while ($length-- > 0) {
                $this->append($value);
            }
        }

        return $this;
    }

    /**
     * Fill data array with given keys & value.
     *
     * @param  array<int|string> $keys
     * @param  mixed|null        $value
     * @return self
     * @since  5.0
     */
    public function fillKeys(array $keys, mixed $value = null): self
    {
        $this->readOnlyCheck();

        $this->data = array_fill_keys($keys, $value);

        return $this;
    }

    /**
     * Get an item from data array with given key.
     *
     * @param  int|string $key
     * @return mixed
     */
    public function item(int|string $key): mixed
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
        if ($keys === null) {
            return $this->data;
        }

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->get($key);
        }
        return $items;
    }
}

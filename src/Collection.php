<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\collection;

use froq\util\Arrays;
use froq\collection\{AbstractCollection, CollectionException, AccessTrait};
use ArrayAccess;

/**
 * Collection.
 * @package froq\collection
 * @object  froq\collection\Collection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
class Collection extends AbstractCollection implements ArrayAccess
{
    /**
     * Access Trait.
     * @see froq\collection\AccessTrait
     * @since 4.0
     */
    use AccessTrait;

    /**
     * Constructor.
     * @param array<int|string, any>|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    /**
     * Set data.
     * @param  array $data
     * @param  bool  $override
     * @return self (static)
     * @throws froq\collection\CollectionException
     * @since  4.0
     * @override
     */
    public function setData(array $data, bool $override = true): self
    {
        foreach (array_keys($data) as $key) {
            if ($key === '') {
                throw new CollectionException('Only int & string keys are accepted for "%s" object, '.
                    'empty string (probably null key) given', [static::class]);
            }
            if (!is_int($key) && !is_string($key)) {
                throw new CollectionException('Only int & string keys are accepted for "%s" object, '.
                    '"%s" given', [static::class, gettype($key)]);
            }
        }

        $this->readOnlyCheck();

        return parent::setData($data, $override);
    }

    /**
     * Set.
     * @param  int|string|array<int|string>|null $key
     * @param  any|null                          $value
     * @return self
     */
    public function set($key, $value = null): self
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
     * Get.
     * @param  int|string|array<int|string> $key
     * @param  any|null                     $valueDefault
     * @return any|null
     */
    public function get($key, $valueDefault = null)
    {
        return is_array($key) ? Arrays::getAll($this->data, $key, $valueDefault)
                              : Arrays::get($this->data, $key, $valueDefault);
    }

    /**
     * Pull.
     * @param  int|string|array<int|string> $key
     * @param  any|null                     $valueDefault
     * @return any|null
     * @since  3.0
     */
    public function pull($key, $valueDefault = null)
    {
        $this->readOnlyCheck();

        return is_array($key) ? Arrays::pullAll($this->data, $key, $valueDefault)
                              : Arrays::pull($this->data, $key, $valueDefault);
    }

    /**
     * Check.
     * @param  int|string $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Has key.
     * @param  int|string $key
     * @return bool
     */
    public function hasKey($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
    }

    /**
     * Add.
     * @param  int|string|array<int|string, any> $key
     * @param  any|null                          $value
     * @return self
     * @since  3.0
     */
    public function add($key, $value = null): self
    {
        $this->readOnlyCheck();

        @ [$key, $value] = is_array($key) ? $key : [$key, $value];

        if (isset($this->data[$key])) {
            $this->data[$key] = Arrays::flatten([$this->data[$key], $value]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Remove.
     * @param  int|string|array<int|string> $key
     * @return self
     */
    public function remove($key): self
    {
        $this->readOnlyCheck();

        Arrays::removeAll($this->data, (array) $key);

        return $this;
    }

    /**
     * Pop.
     * @return any
     * @since  4.0
     */
    public function pop()
    {
        $this->readOnlyCheck();

        return array_pop($this->data);
    }

    /**
     * Unpop (aka push).
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
     * Shift.
     * @return any
     * @since  4.0
     */
    public function shift()
    {
        $this->readOnlyCheck();

        return array_shift($this->data);
    }

    /**
     * Unshift.
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
     * Reverse.
     * @param  bool $preserveKeys
     * @return self
     * @since  4.0
     */
    public function reverse(bool $preserveKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_reverse($this->data, $preserveKeys);

        return $this;
    }

    /**
     * Unique.
     * @return self
     * @since  4.0
     */
    public function unique(): self
    {
        $this->readOnlyCheck();

        $this->data = array_unique($this->data, SORT_REGULAR);

        return $this;
    }

    /**
     * Slice.
     * @param  int      $offset
     * @param  int|null $length
     * @param  bool     $preserveKeys
     * @return self
     * @since  4.0
     */
    public function slice(int $offset, int $length = null, bool $preserveKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_slice($this->data, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * Split.
     * @param  int  $size
     * @param  bool $preserveKeys
     * @return self
     * @since  4.0
     */
    public function split(int $size, bool $preserveKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_chunk($this->data, $size, $preserveKeys);

        return $this;
    }

    /**
     * Join.
     * @param  string $glue
     * @return string
     * @since  4.0
     */
    public function join(string $glue): string
    {
        return join($glue, $this->data);
    }

    /**
     * Merge.
     * @param  iterable $data
     * @return self
     * @since  4.0
     */
    public function merge(iterable $data): self
    {
        $this->readOnlyCheck();

        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Flatten.
     * @param  bool $useKeys
     * @param  bool $fixKeys
     * @param  bool $oneDimension
     * @return self
     * @since  4.0
     */
    public function flatten(bool $useKeys = false, bool $fixKeys = false, bool $oneDimension = false): array
    {
        $this->readOnlyCheck();

        $this->data = Arrays::flatten($this->data, $useKeys, $fixKeys, $oneDimension);

        return $this;
    }

    /**
     * Sweep.
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
     * Search.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     * @since  4.0
     */
    public function search($value, bool $strict = true): bool
    {
        $key = array_search($value, $this->data, $strict);

        return ($key !== false);
    }

    /**
     * Test (like JavaScript Array.some()).
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function test(callable $func): bool
    {
        return Arrays::test($this->data, $func);
    }

    /**
     * Test all (like JavaScript Array.every()).
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function testAll(callable $func): bool
    {
        return Arrays::testAll($this->data, $func);
    }

    /**
     * Find.
     * @param  callable $func
     * @return any|null
     * @since  4.3
     */
    public function find(callable $func)
    {
        return Arrays::find($this->data, $func);
    }

    /**
     * Find all.
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
     * Random.
     * @param  int  $size
     * @param  bool $pack Return [key,value] pairs.
     * @return any|null
     * @since  4.0
     */
    public function random(int $size = 1, bool $pack = false)
    {
        return Arrays::random($this->data, $size, $pack);
    }

    /**
     * Shuffle.
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
     * Flip.
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
     * Fill.
     * @param  any $value
     * @return self
     * @since  4.0
     */
    public function fill($value): self
    {
        $this->readOnlyCheck();

        foreach (array_keys($this->data) as $key) {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Sort.
     * @param  string|null $funcName
     * @param  int         $flags
     * @return self
     * @throws froq\collection\CollectionException
     */
    public function sort(string $funcName = null, int $flags = 0): self
    {
        $this->readOnlyCheck();

        static $funcNames = ['rsort', 'asort', 'arsort', 'ksort', 'krsort'];

        if ($funcName && !in_array($funcName, $funcNames)) {
            throw new CollectionException('Invalid sort function "%s", valids are: %s and null',
                [$funcName, join(', ', $funcNames)]);
        }

        call_user_func_array($funcName ?: 'sort', [&$this->data, $flags]);

        return $this;
    }

    /**
     * USort.
     * @param  callable    $func
     * @param  string|null $funcName
     * @return self
     * @throws froq\collection\CollectionException
     * @since  4.0
     */
    public function usort(callable $func, string $funcName = null): self
    {
        $this->readOnlyCheck();

        static $funcNames = ['uasort', 'uksort'];

        if ($funcName && !in_array($funcName, $funcNames)) {
            throw new CollectionException('Invalid usort function "%s", valids are: %s and null',
                [$funcName, join(', ', $funcNames)]);
        }

        call_user_func_array($funcName ?: 'usort', [&$this->data, $func]);

        return $this;
    }

    /**
     * Sort locale.
     * @param  string|null $locale
     * @return self
     * @since  4.0
     */
    public function sortLocale(string $locale = null): self
    {
        $this->readOnlyCheck();

        if ($locale == null) { // Use current locale.
            usort($this->data, fn($a, $b) => strcoll($a, $b));
        } else {
            // Get & cache.
            static $default; $default ??= setlocale(LC_COLLATE, 0);

            setlocale(LC_COLLATE, $locale);
            usort($this->data, fn($a, $b) => strcoll($a, $b));

            if ($default !== null) { // Restore.
                setlocale(LC_COLLATE, $default);
            }
        }

        return $this;
    }

    /**
     * Sort natural.
     * @param  bool $noCase
     * @return self
     * @since  4.0
     */
    public function sortNatural(bool $noCase = false): self
    {
        $this->readOnlyCheck();

        !$noCase ? natsort($this->data) : natcasesort($this->data);

        return $this;
    }

    /**
     * Item.
     * @param  int|string $key
     * @return any
     */
    public function item($key)
    {
        return $this->get($key);
    }

    /**
     * Items.
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
     * Index.
     * @param  any  $value
     * @param  bool $strict
     * @return int|string|null
     * @since  4.0
     */
    public function index($value, bool $strict = true)
    {
        return Arrays::index($this->data, $value, $strict);
    }

    /**
     * First.
     * @return any|null
     * @since  4.0
     */
    public function first()
    {
        $key = $this->firstKey();

        return ($key !== null) ?  $this->data[$key] : null;
    }

    /**
     * First key.
     * @return int|string
     * @since  4.0
     */
    public function firstKey()
    {
        return array_key_first($this->data);
    }

    /**
     * Last.
     * @return any|null
     * @since  4.0
     */
    public function last()
    {
        $key = $this->lastKey();

        return ($key !== null) ? $this->data[$key] : null;
    }

    /**
     * Last key.
     * @return int|string
     * @since  4.0
     */
    public function lastKey()
    {
        return array_key_last($this->data);
    }
}

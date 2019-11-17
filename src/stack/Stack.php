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

namespace froq\collection\stack;

use froq\collection\AbstractCollection;
use froq\collection\stack\StackException;

/**
 * Stack.
 *
 * This is not an implementation of https://en.wikipedia.org/wiki/Stack_(abstract_data_type) but
 * simply designed to be available key type check in here or extender objects. Inspired by
 * Hashtable of JAVA. @link https://docs.oracle.com/javase/8/docs/api/java/util/Hashtable.html
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\Stack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Stack extends AbstractCollection
{
    /**
     * Skip key check (tick from SetStack/MapStack).
     * @var bool
     */
    protected bool $skipKeyCheck = false;

    /**
     * Constructor.
     * @param  array<int|string, any>|null $data
     * @throws froq\collection\stack\StackException
     */
    public function __construct(array $data = null)
    {
        if (!$this->skipKeyCheck) {
            foreach (array_keys($data) as $key) {
                if (!is_int($key) && !is_string($key)) {
                    throw new StackException('Only int and string keys are accepted for '.
                        static::class);
                }
            }
        }

        parent::__construct($data);
    }

    /**
     * Has.
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
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public function set($key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  int|string $key
     * @return any|null
     */
    public function get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Add.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public function add($key, $value): self
    {
        if (isset($this->data[$key])) {
            $this->data[$key] = self::flatten([$this->data[$key], $value]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return void
     */
    public function remove($key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Flatten.
     * @param  array $array
     * @return array
     */
    private static final function flatten(array $array): array
    {
        $ret = [];

        array_walk_recursive($array, function($re) use (&$ret) {
            $ret[] = $re;
        });

        return $ret;
    }
}

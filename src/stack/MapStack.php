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

use froq\util\Arrays;
use froq\collection\AbstractCollection;
use froq\collection\stack\StackException;

/**
 * Map Stack.
 *
 * This is not an implementation of Stack (https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
 * but simply designed to be available to string type key check here. Inspired by HashMap of JAVA
 * (https://docs.oracle.com/javase/8/docs/api/java/util/HashMap.html).
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\MapStack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class MapStack extends AbstractCollection
{
    /**
     * Constructor.
     * @param  array<string, any>|null $data
     * @throws froq\collection\stack\StackException
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            foreach (array_keys($data) as $key) {
                if (!is_string($key)) {
                    throw new StackException('Only string keys are accepted for "%s" stack',
                        [static::class]);
                }
            }
        }

        parent::__construct($data);
    }

    /**
     * Add.
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function add(string $key, $value): self
    {
        if (isset($this->data[$key])) {
            $this->data[$key] = Arrays::flatten([$this->data[$key], $value]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Set.
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function set(string $key, $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  string   $key
     * @param  any|null $valueDefault
     * @return any
     */
    public final function get(string $key, $valueDefault = null)
    {
        return $this->data[$key] ?? $valueDefault;
    }

    /**
     * Remove.
     * @param  string $key
     * @return self
     */
    public final function remove(string $key): self
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * Has.
     * @param  string $key
     * @return bool
     */
    public final function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Has key.
     * @param  string $key
     * @return bool
     */
    public final function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
    }
}

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

use froq\collection\{AbstractCollection, AccessTrait};
use froq\collection\stack\{StackException, StackTrait};
use ArrayAccess;

/**
 * Stack.
 *
 * This is not an implementation of Stack (https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
 * but simply designed to be able for checking key types here or in extender objects, and also to
 * prevent the modifications in read-only mode.
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\Stack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Stack extends AbstractCollection implements ArrayAccess
{
    /**
     * Access & Stack Trait.
     * @see froq\collection\AccessTrait
     * @see froq\collection\stack\StackTrait
     */
    use AccessTrait, StackTrait;

    /**
     * Constructor.
     * @param  array<int|string, any>|null $data
     * @param  bool|null                   $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data);

        $this->readOnly($readOnly);
    }

    /**
     * Set data.
     * @param  array $data
     * @param  bool  $override
     * @return self (static)
     * @throws froq\collection\stack\StackException
     * @override
     */
    public final function setData(array $data, bool $override = true): self
    {
        foreach (array_keys($data) as $key) {
            if ($key === '') {
                throw new StackException('Only int and string keys are accepted for "%s" stack, '.
                    'empty string (probably null key) given', [static::class]);
            }
            if (!is_int($key) && !is_string($key)) {
                throw new StackException('Only int and string keys are accepted for "%s" stack, '.
                    '"%s" given', [static::class, gettype($key)]);
            }
        }

        $this->readOnlyCheck();

        return parent::setData($data, $override);
    }

    /**
     * Add.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function add($key, $value): self
    {
        return $this->_add($key, $value);
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function set($key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * Get.
     * @param  int|string $key
     * @param  any|null   $valueDefault
     * @return any|null
     */
    public final function get($key, $valueDefault = null)
    {
        return $this->_get($key, $valueDefault);
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return bool
     */
    public final function remove($key): bool
    {
        return $this->_remove($key);
    }

    /**
     * Has.
     * @param  int|string $key
     * @return bool
     */
    public final function has($key): bool
    {
        return $this->_has($key);
    }

    /**
     * Has key.
     * @param  int|string $key
     * @return bool
     */
    public final function hasKey($key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return $this->_hasValue($value, $strict);
    }
}

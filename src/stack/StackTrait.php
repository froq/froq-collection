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

/**
 * Stack Trait.
 *
 * Represents a trait that used in `froq\collection\stack` internally for stacks to avoid code
 * repetition.
 *
 * @package  froq\collection\stack
 * @object   froq\collection\stack\StackTrait
 * @author   Kerem Güneş <k-gun@mail.com>
 * @since    4.0
 * @internal Used in froq\collection\stack only.
 */
trait StackTrait
{
    /**
     * Add.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    private function _add($key, $value): self
    {
        $this->readOnlyCheck();

        if (isset($this->data[$key])) {
            $this->data[$key] = Arrays::flatten([$this->data[$key], $value]);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    private function _set($key, $value): self
    {
        $this->readOnlyCheck();

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  int|string $key
     * @param  any|null   $valueDefault
     * @return any|null
     */
    private function _get($key, $valueDefault = null)
    {
        return $this->data[$key] ?? $valueDefault;
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return bool
     */
    private function _remove($key): bool
    {
        $this->readOnlyCheck();

        if (isset($this->data[$key])) {
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    /**
     * Has.
     * @param  int|string $key
     * @return bool
     */
    private function _has($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Has key.
     * @param  int|string $key
     * @return bool
     */
    private function _hasKey($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    private function _hasValue($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }
}

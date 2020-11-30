<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
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
     * @param  any|null   $default
     * @return any|null
     */
    private function _get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
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

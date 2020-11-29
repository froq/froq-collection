<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection\stack;

use froq\collection\{AbstractCollection, AccessTrait};
use froq\collection\stack\{StackException, StackTrait};
use ArrayAccess;

/**
 * Map Stack.
 *
 * This is not an implementation of Stack (https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
 * but simply designed to be able for checking key types here or in extender objects, and also to
 * prevent the modifications in read-only mode.
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\MapStack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class MapStack extends AbstractCollection implements ArrayAccess
{
    /**
     * Access & Stack Trait.
     * @see froq\collection\AccessTrait
     * @see froq\collection\stack\StackTrait
     */
    use AccessTrait, StackTrait;

    /**
     * Constructor.
     * @param  array<string, any>|null $data
     * @param  bool|null               $readOnly
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
                throw new StackException('Only string keys are accepted for "%s" stack, '.
                    'empty string (probably null key) given', [static::class]);
            }
            if (!is_string($key)) {
                throw new StackException('Only string keys are accepted for "%s" stack, '.
                    '"%s" given', [static::class, gettype($key)]);
            }
        }

        $this->readOnlyCheck();

        return parent::setData($data, $override);
    }

    /**
     * Add.
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function add(string $key, $value): self
    {
        return $this->_add($key, $value);
    }

    /**
     * Set.
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function set(string $key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * Get.
     * @param  string   $key
     * @param  any|null $valueDefault
     * @return any|null
     */
    public final function get(string $key, $valueDefault = null)
    {
        return $this->_get($key, $valueDefault);
    }

    /**
     * Remove.
     * @param  string $key
     * @return bool
     */
    public final function remove(string $key): bool
    {
        return $this->_remove($key);
    }

    /**
     * Has.
     * @param  string $key
     * @return bool
     */
    public final function has(string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * Has key.
     * @param  string $key
     * @return bool
     */
    public final function hasKey(string $key): bool
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

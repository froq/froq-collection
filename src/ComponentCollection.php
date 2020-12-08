<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException, AccessTrait, AccessMagicTrait};
use ArrayAccess;

/**
 * Component Collection.
 *
 * Represents a named array structure that restricts all access and mutation operations considering
 * given names only, also provides calls via `__call()` magic for given names.
 *
 * @package froq\collection
 * @object  froq\collection\ComponentCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.5
 */
class ComponentCollection extends AbstractCollection implements ArrayAccess
{
    /**
     * Access & Access Magic Trait.
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /**
     * Names (settable/gettable names).
     * @var array
     */
    protected static array $names = [];

    /**
     * Throws (name errors).
     * @var bool
     */
    protected static bool $throws = true;

    /**
     * Constructor.
     * @param array<string> $names
     * @param bool          $throws
     */
    public function __construct(array $names, bool $throws = true)
    {
        self::$names  = $names;
        self::$throws = $throws;

        parent::__construct(null);
    }

    /**
     * Call.
     * @param  string $method
     * @param  array  $methodArgs
     * @return self|any
     * @throws froq\collection\CollectionException
     */
    public function __call(string $method, array $methodArgs = [])
    {
        // Eg: setFoo('bar') => set('foo', 'bar') or getFoo() => get('foo').
        if (strpos($method, 'set') === 0) {
            return $this->set(lcfirst(substr($method, 3)), $methodArgs[0]);
        } elseif (strpos($method, 'get') === 0) {
            return $this->get(lcfirst(substr($method, 3)));
        }

        throw new CollectionException("Invalid method call as '%s()' (tip: '%s' object is a "
            . "component collection and only set/get prefixed methods can be called via __call() "
            . "if method not exists)", [$method, static::class]);
    }

    /**
     * Set data.
     * @param  array<string, any> $data
     * @param  bool               $override
     * @return self (static)
     * @throws froq\collection\CollectionException
     * @since  4.0
     * @override
     */
    public final function setData(array $data, bool $override = true): self
    {
        foreach (array_keys($data) as $name) {
            if ($name === '') {
                throw new CollectionException("Only string names are accepted for '%s' object, "
                    . "empty string (probably null name) given", [static::class]);
            }
            if (!is_string($name)) {
                throw new CollectionException("Only string names are accepted for '%s' object, "
                    . "'%s' given", [static::class, gettype($name)]);
            }

            $this->nameCheck($name);
        }

        return parent::setData($data, $override);
    }

    /**
     * Names.
     * @return array<string>
     */
    public final function names(): array
    {
        return self::$names;
    }

    /**
     * Throws.
     * @return bool
     */
    public final function throws(): bool
    {
        return self::$throws;
    }

    /**
     * Has.
     * @param  string $name
     * @return bool
     */
    public final function has(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Has name.
     * @param  string $name
     * @return bool
     */
    public final function hasName(string $name): bool
    {
        return in_array($name, self::$names);
    }

    /**
     * Set.
     * @param  string $name
     * @param  any    $value
     * @return self
     */
    public final function set(string $name, $value): self
    {
        $this->nameCheck($name) || $this->readOnlyCheck();

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  string $name
     * @return any|null
     */
    public final function get(string $name)
    {
        $this->nameCheck($name);

        return $this->data[$name] ?? null;
    }

    /**
     * Remove.
     * @param  string $name
     * @return void
     */
    public final function remove(string $name): void
    {
        $this->nameCheck($name) || $this->readOnlyCheck();

        unset($this->data[$name]);
    }

    /**
     * Name check.
     * @param  string $name
     * @return void
     * @throws froq\collection\CollectionException
     */
    private function nameCheck(string $name): void
    {
        if (!self::$throws) {
            return;
        }
        if (in_array($name, self::$names)) {
            return;
        }

        throw new CollectionException("Invalid component name '%s' given to '%s' object, valids are: %s",
            [$name, static::class, join(', ', self::$names)]);
    }
}

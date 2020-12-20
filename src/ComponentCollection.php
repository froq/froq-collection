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
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /** @var array */
    protected static array $names = [];

    /** @var bool */
    protected static bool $throws;

    /**
     * Constructor.
     *
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
     * Magic call for a non-existing method but an existing component.
     *
     * @param  string $method
     * @param  array  $methodArgs
     * @return self|any
     * @throws froq\collection\CollectionException
     */
    public final function __call(string $method, array $methodArgs = [])
    {
        // Eg: setFoo('bar') => set('foo', 'bar') or getFoo() => get('foo').
        if (str_starts_with($method, 'set')) {
            return $this->set(lcfirst(substr($method, 3)), $methodArgs[0]);
        } elseif (str_starts_with($method, 'get')) {
            return $this->get(lcfirst(substr($method, 3)));
        }

        throw new CollectionException('Invalid method call as %s(), [tip: %s object is a component'
            . ' collection and only set/get prefixed methods can be called via __call() if not exist]'
            , [$method, static::class]
        );
    }

    /**
     * Set data.
     *
     * @param  array<string, any> $data
     * @param  bool               $reset
     * @return self
     * @since  4.0
     * @override
     */
    public final function setData(array $data, bool $reset = true): self
    {
        foreach (array_keys($data) as $name) {
            $this->nameCheck((string) $name);
        }

        return parent::setData($data, $reset);
    }

    /**
     * Get names.
     *
     * @return array<string>
     */
    public final function names(): array
    {
        return self::$names;
    }

    /**
     * Get throws state.
     *
     * @return bool
     */
    public final function throws(): bool
    {
        return self::$throws;
    }

    /**
     * Check whether a component exists in data stack with given name.
     *
     * @param  string $name
     * @return bool
     */
    public final function has(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Check whether a name exists in data stack.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasName(string $name): bool
    {
        return in_array($name, self::$names);
    }

    /**
     * Put a component by given name to data stack.
     *
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
     * Get a component by given name from data stack.
     *
     * @param  string $name
     * @return any|null
     */
    public final function get(string $name)
    {
        $this->nameCheck($name);

        return $this->data[$name] ?? null;
    }

    /**
     * Remove a component from data stack by given name.
     *
     * @param  string $name
     * @return void
     */
    public final function remove(string $name): void
    {
        $this->nameCheck($name) || $this->readOnlyCheck();

        unset($this->data[$name]);
    }

    /**
     * Name check for a valid component name.
     *
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

        throw new CollectionException('Invalid component name `%s` given to %s object, valids are: %s',
            [$name, static::class, join(', ', self::$names)]);
    }
}

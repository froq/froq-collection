<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException};
use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};
use ArrayAccess;

/**
 * Component Collection.
 *
 * Represents a named array structure that restricts all access and mutation operations considering
 * given names only, also provides calls via `__call()` magic for given names.
 *
 * @package froq\collection
 * @object  froq\collection\ComponentCollection
 * @author  Kerem Güneş
 * @since   3.5
 */
class ComponentCollection extends AbstractCollection implements ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\AccessMagicTrait
     * @see froq\collection\trait\GetTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait, GetTrait;

    /** @var array */
    protected static array $names = [];

    /** @var bool */
    protected static bool $throws;

    /**
     * Constructor.
     *
     * @param array<string> $names
     * @param bool          $throws
     * @param bool|null     $readOnly
     */
    public function __construct(array $names, bool $throws = true, bool $readOnly = null)
    {
        self::$names  = $names;
        self::$throws = $throws;

        parent::__construct(array_fill_keys($names, null), $readOnly);
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

        throw new CollectionException(
            'Invalid method call as %s(), [tip: %s object is a component collection '.
            'and only set/get prefixed methods can be called via __call() if not exist]',
            [$method, static::class]
        );
    }

    /**
     * Set data.
     *
     * @param  array<string, any> $data
     * @param  bool               $reset
     * @return self
     * @since  4.0
     * @causes froq\collection\CollectionException
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
     * Check whether given name set in data array.
     *
     * @param  string $name
     * @return bool
     */
    public final function has(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Check whether given name exists in data array.
     *
     * @param  string $name
     * @return bool
     */
    public final function hasName(string $name): bool
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Check whether given value exists in data array (with/without strict mode).
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Set a component.
     *
     * @param  string $name
     * @param  any    $value
     * @return self
     * @causes froq\collection\CollectionException
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function set(string $name, $value): self
    {
        $this->readOnlyCheck();
        $this->nameCheck($name);

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Get a component.
     *
     * @param  string   $name
     * @param  any|null $default
     * @return any|null
     * @causes froq\collection\CollectionException
     */
    public final function get(string $name, $default = null)
    {
        $this->nameCheck($name);

        return $this->data[$name] ?? $default;
    }

    /**
     * Remove a component.
     *
     * @param  string $name
     * @return void
     * @causes froq\collection\CollectionException
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function remove(string $name): void
    {
        $this->readOnlyCheck();
        $this->nameCheck($name);

        unset($this->data[$name]);
    }

    /**
     * Check for a valid component name.
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

        throw new CollectionException(
            'Invalid component name `%s` given to %s object, valids are: %s',
            [$name, static::class, join(', ', self::$names)]
        );
    }
}

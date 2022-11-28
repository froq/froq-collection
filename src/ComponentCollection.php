<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};

/**
 * A named-array collection, restricts all access/mutation operations considering
 * given names only, also provides calls via `__call()` magic for given names.
 *
 * @package froq\collection
 * @object  froq\collection\ComponentCollection
 * @author  Kerem Güneş
 * @since   3.5
 */
class ComponentCollection extends AbstractCollection implements \ArrayAccess
{
    use AccessTrait, AccessMagicTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array     $names
     * @param bool|null $readOnly
     * @throws froq\collection\CollectionException
     */
    public function __construct(array $names, bool $readOnly = null)
    {
        $names ?: throw new CollectionException('No names given');

        parent::__construct(array_fill_keys($names, null), $readOnly);
    }

    /**
     * Call for a non-existing method but an existing component.
     *
     * @param  string $method
     * @param  array  $methodArgs
     * @return mixed|null|self
     * @throws froq\collection\CollectionException
     * @magic
     */
    public final function __call(string $method, array $methodArgs = []): mixed
    {
        // Eg: setFoo('bar') => set('foo', 'bar') or getFoo() => get('foo').
        if (str_starts_with($method, 'set')) {
            if (!array_key_exists(0, $methodArgs)) {
                throw new CollectionException('No argument given for %s() call', $method);
            }
            return $this->set(lcfirst(substr($method, 3)), $methodArgs[0]);
        } elseif (str_starts_with($method, 'get')) {
            return $this->get(lcfirst(substr($method, 3)), $methodArgs[0] ?? null);
        }

        throw new CollectionException(
            'Invalid method call as %s(), [tip: %s class is a component collection '.
            'and only set/get prefixed methods can be called via __call() if not exist]',
            [$method, $this::class]
        );
    }

    /**
     * Get names.
     *
     * @return array
     */
    public final function names(): array
    {
        return array_keys($this->data);
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
     * @param  mixed $value
     * @param  bool  $strict
     * @return bool
     */
    public final function hasValue(mixed $value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Set a component.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return self
     * @causes froq\collection\CollectionException
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function set(string $name, mixed $value): self
    {
        $this->readOnlyCheck();
        $this->nameCheck($name);

        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Get a component.
     *
     * @param  string     $name
     * @param  mixed|null $default
     * @return mixed|null
     * @causes froq\collection\CollectionException
     */
    public final function get(string $name, mixed $default = null): mixed
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

        $this->data[$name] = null;
    }

    /**
     * Check for a valid component name.
     *
     * @throws froq\collection\CollectionException
     */
    private function nameCheck(string $name): void
    {
        if (!$this->hasName($name)) {
            throw new CollectionException(
                'Invalid component name %q for %s [valids: %A]',
                [$name, $this::class, $this->names()]
            );
        }
    }
}

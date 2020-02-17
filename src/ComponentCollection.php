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

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException, AccessTrait};
use ArrayAccess;

/**
 * Component Collection.
 *
 * Represents a named array structure that restricts all access and mutation operations considering
 * given names only.
 *
 * @package froq\collection
 * @object  froq\collection\ComponentCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.5, 4.0
 */
class ComponentCollection extends AbstractCollection implements ArrayAccess
{
    /**
     * Access Trait.
     * @see froq\collection\AccessTrait
     * @since 4.0
     */
    use AccessTrait;

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
        self::$names = $names;
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
        $cmd  = substr($method, 0, 3);
        $name = substr($method, 3);

        if ($cmd == 'set') {
            return $this->set(lcfirst($name), $methodArgs[0]);
        } elseif ($cmd == 'get') {
            return $this->get(lcfirst($name));
        }

        throw new CollectionException('Invalid method call as "%s" (tip: only set/get prefixed '.
            'methods can be called via "%s::__call()" if called method not exists)',
            [$method, static::class]);
    }

    /**
     * Set data.
     * @param  array<string, any> $data
     * @return self (static)
     * @throws froq\collection\CollectionException
     * @override
     */
    public final function setData(array $data): self
    {
        foreach (array_keys($data) as $name) {
            if ($name === '') {
                throw new CollectionException('Only string names are accepted for "%s" object, '.
                    'empty string (probably null name) given', [static::class]);
            }
            if (!is_string($name)) {
                throw new CollectionException('Only string names are accepted for "%s" object, '.
                    '"%s" given', [static::class, gettype($name)]);
            }
        }

        return parent::setData($data);
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
    private final function nameCheck(string $name): void
    {
        if (!self::$throws) {
            return;
        }
        if (in_array($name, self::$names)) {
            return;
        }

        throw new CollectionException('Invalid name "%s" given, valid are: %s',
            [$name, join(', ', self::$names)]);
    }
}

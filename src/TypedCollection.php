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

use froq\collection\{AbstractCollection, CollectionException};

/**
 * Typed Collection.
 *
 * Represents a typed array structure that inspired by TypedArray of JavaScript. @link
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/TypedArray
 *
 * @package froq\collection
 * @object  froq\collection\TypedCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class TypedCollection extends AbstractCollection
{
    /**
     * Data type.
     * @var string
     */
    protected string $dataType;

    /**
     * Constructor.
     * @param  array|null  $data
     * @param  string|null $dataType
     * @throws froq\collection\CollectionException If no type set.
     */
    public function __construct(array $data = null, string $dataType = null)
    {
        // Data type might be defined in extender class.
        $this->dataType = $dataType ?? $this->dataType ?? '';
        if ($this->dataType == '') {
            throw new CollectionException('Data type is required, it must be defined like '.
                '"protected string $dataType = \'int\';" or given at constructor calls as '.
                'second argument');
        }

        $data && $this->setData($data);
    }

    /**
     * Get data type.
     * @return string
     */
    public final function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * Set data.
     * @param  array $data
     * @return self (static)
     * @override
     */
    public function setData(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->typeCheck($value);
        }

        return parent::setData($data);
    }

    /**
     * Add.
     * @param  any $value
     * @return self
     */
    public final function add($value): self
    {
        $this->typeCheck($value);

        $this->data[] = $value;

        return $this;
    }

    /**
     * Has.
     * @param  int|string $key
     * @return bool
     */
    public final function has($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function set($key, $value): self
    {
        $this->typeCheck($value);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  int|string $key
     * @return any|null
     */
    public final function get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return void
     */
    public final function remove($key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Check data type.
     * @param  any $value
     * @return void
     * @throws froq\collection\CollectionException
     */
    private final function typeCheck($value): void
    {
        $type = gettype($value);

        // Objects.
        if ($type == 'object') {
            // All objects.
            if ($this->dataType == 'object') {
                return;
            }
            if ($value instanceof $this->dataType) {
                return;
            }

            // Anonymous classes contain 0 bytes and verbosed file path etc.
            $class = substr($class = get_class($value), 0, strpos($class, "\0") ?: strlen($class));

            throw new CollectionException(sprintf('Each value must be type of %s, %s given',
                $this->dataType, $class));
        }

        // Types to check & translate.
        static $types = ['int', 'float', 'string', 'bool', 'array', 'resource'];
        static $typer = ['integer' => 'int', 'double' => 'float', 'boolean' => 'bool'];

        // Shorter types must be used (constructor or in extender class).
        $type = strtr($type, $typer);

        // Others.
        if ($type != $this->dataType && in_array($type, $types)) {
            throw new CollectionException(sprintf('Each value must be type of %s, %s given',
                $this->dataType, $type));
        }
    }
}

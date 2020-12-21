<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException};

/**
 * Typed Collection.
 *
 * Represents a typed array structure that accepts strict values only which forced with `$dataType` property.
 *
 * @package froq\collection
 * @object  froq\collection\TypedCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class TypedCollection extends AbstractCollection
{
    /** @var string */
    protected string $dataType;

    /**
     * Constructor.
     *
     * @param  array|null  $data
     * @param  string|null $dataType
     * @throws froq\collection\CollectionException
     */
    public function __construct(array $data = null, string $dataType = null)
    {
        // Data type might be defined in extender class.
        $this->dataType = $dataType ?? $this->dataType ?? '';

        if ($this->dataType == '') {
            throw new CollectionException('Data type is required, it must be defined like'
                . ' `protected string $dataType = \'int\'` or given at constructor calls as'
                . ' second argument');
        }

        parent::__construct($data);
    }

    /**
     * Get data type.
     *
     * @return string
     */
    public final function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * Set data.
     *
     * @param  array<int|string, any> $data
     * @param  bool                   $reset
     * @return self
     * @override
     */
    public final function setData(array $data, bool $reset = true): self
    {
        foreach ($data as $value) {
            $this->typeCheck($value);
        }

        return parent::setData($data, $reset);
    }

    /**
     * Check whether a keyed/indexed item was set in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether a key/index exists in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check with/without strict mode whether data stack has given value.
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
     * Add (append) an item to data stack.
     *
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
     * Put an item by given key/index to data stack.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function set(int|string $key, $value): self
    {
        $this->typeCheck($value);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item by given key/index from data stack.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return any|null
     */
    public final function get(int|string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Remove an item by given key/index from data stack.
     *
     * @param  int|string $key
     * @return void
     */
    public final function remove(int|string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Check data type.
     *
     * @param  any $value
     * @return void
     * @throws froq\collection\CollectionException
     */
    private function typeCheck($value): void
    {
        // Any type?
        if ($this->dataType == 'any') {
            return;
        }

        if (is_object($value)) {
            // All objects.
            if ($this->dataType == 'object' || $value instanceof $this->dataType) {
                return;
            }

            throw new CollectionException('Each value must be type of %s, %s given',
                [$this->dataType, $value::class]);
        }

        if (($this->dataType == 'scalar' && is_scalar($value))
            || ($this->dataType == 'number' && is_number($value))) {
            return;
        }

        $type = get_type($value);

        if ($type != $this->dataType) {
            $types = explode('|', $this->dataType);

            // @fix, @todo: Make namespace resolution for short class names.
            if (in_array($type, $types)) {
                return;
            }

            throw new CollectionException('Each value must be type of %s, %s given',
                [$this->dataType, $type]);
        }
    }
}

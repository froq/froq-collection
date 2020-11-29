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
 * Represents a typed array structure that accepts strict values only which indicated with
 * `$dataType` property.
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
     * @throws froq\collection\CollectionException
     */
    public function __construct(array $data = null, string $dataType = null)
    {
        // Data type might be defined in extender class.
        $this->dataType = $dataType ?? $this->dataType ?? null;
        if ($this->dataType == null) {
            throw new CollectionException('Data type is required, it must be defined like '.
                '"protected string $dataType = \'int\';" or given at constructor calls as '.
                'second argument');
        }

        parent::__construct($data);
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
     * @param  bool  $override
     * @return self (static)
     * @override
     */
    public final function setData(array $data, bool $override = true): self
    {
        foreach ($data as $key => $value) {
            $this->typeCheck($value);
        }

        return parent::setData($data, $override);
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
     * Has key.
     * @param  int|string $key
     * @return bool
     */
    public final function hasKey($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
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
    private function typeCheck($value): void
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

        // Shorter types must be used (in constructor or extender class).
        $type = strtr($type, $typer);

        // Others.
        if ($type != $this->dataType && in_array($type, $types)) {
            throw new CollectionException(sprintf('Each value must be type of %s, %s given',
                $this->dataType, $type));
        }
    }
}

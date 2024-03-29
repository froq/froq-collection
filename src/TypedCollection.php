<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait, HasTrait};

/**
 * A typed-array class, accepts strict values only forced by `$dataType` property.
 *
 * @package froq\collection
 * @class   froq\collection\TypedCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class TypedCollection extends AbstractCollection implements \ArrayAccess
{
    use AccessTrait, AccessMagicTrait, GetTrait, HasTrait;

    /** Data type. */
    protected string $dataType;

    /**
     * @throws froq\collection\CollectionException
     * @override
     */
    public function __construct(iterable $data = [], string $dataType = null)
    {
        // Data type might be defined in extender class.
        $this->dataType = $dataType ?? $this->dataType ?? '';

        if (!$this->dataType) {
            throw new CollectionException(
                'Data type is required, it must be defined like "protected string $dataType = \'int\'" '.
                'or given at constructor calls as second argument'
            );
        }

        if ($data) foreach ($data as $value) {
            $this->typeCheck($value);
        }

        parent::__construct($data);
    }

    /**
     * Get data type.
     *
     * @return string
     */
    public function dataType(): string
    {
        return $this->dataType;
    }

    /**
     * Add (append) an item.
     *
     * @param  mixed $value
     * @return self
     * @causes froq\collection\CollectionException
     */
    public function add(mixed $value): self
    {
        $this->typeCheck($value);

        $this->data[] = $value;

        return $this;
    }

    /**
     * Set an item.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     * @causes froq\collection\CollectionException
     */
    public function set(int|string $key, mixed $value): self
    {
        $this->typeCheck($value);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed|null
     */
    public function &get(int|string $key, mixed $default = null): mixed
    {
        $value = &$this->data[$key] ?? $default;

        return $value;
    }

    /**
     * Remove an item.
     *
     * @param  int|string $key
     * @return void
     */
    public function remove(int|string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Check data type.
     *
     * @param  mixed $value
     * @return void
     * @throws froq\collection\CollectionException
     */
    private function typeCheck(mixed $value): void
    {
        // Any type?
        if ($this->dataType === 'any' || $this->dataType === 'mixed') {
            return;
        }

        if (is_object($value)) {
            // All objects.
            if ($this->dataType === 'object' || $value instanceof $this->dataType) {
                return;
            }

            throw new CollectionException(
                'Each value must be type of %s, %s given',
                [$this->dataType, $value::class]
            );
        }

        if (($this->dataType === 'scalar' && is_scalar($value))
            || ($this->dataType === 'number' && is_number($value))) {
            return;
        }

        $type = get_type($value);

        if ($type !== $this->dataType) {
            $types = explode('|', $this->dataType);

            if (in_array($type, $types, true)) {
                return;
            }

            throw new CollectionException(
                'Each value must be type of %s, %s given',
                [$this->dataType, $type]
            );
        }
    }
}

<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait, HasTrait};

/**
 * Typed Collection.
 *
 * Represents a typed array structure that accepts strict values only which forced with `$dataType` property.
 *
 * @package froq\collection
 * @object  froq\collection\TypedCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class TypedCollection extends AbstractCollection implements CollectionInterface, \ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\AccessMagicTrait
     * @see froq\collection\trait\GetTrait
     * @see froq\collection\trait\HasTrait
     * @since 5.4, 5.15
     */
    use AccessTrait, AccessMagicTrait, GetTrait, HasTrait;

    /** @var string */
    protected string $dataType;

    /**
     * Constructor.
     *
     * @param array<int|string, any>|null $data
     * @param  string|null                $dataType
     * @param  bool|null                  $readOnly
     * @throws froq\collection\CollectionException
     */
    public function __construct(array $data = null, string $dataType = null, bool $readOnly = null)
    {
        // Data type might be defined in extender class.
        $this->dataType = $dataType ?? $this->dataType ?? '';

        if ($this->dataType == '') {
            throw new CollectionException(
                'Data type is required, it must be defined like `protected string $dataType = \'int\'` '.
                'or given at constructor calls as second argument'
            );
        }

        parent::__construct($data, $readOnly);
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
     * @causes froq\collection\CollectionException
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
     * Add (append) an item.
     *
     * @param  any $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\collection\CollectionException
     */
    public final function add($value): self
    {
        $this->readOnlyCheck();
        $this->typeCheck($value);

        $this->data[] = $value;

        return $this;
    }

    /**
     * Set an item.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\collection\CollectionException
     */
    public final function set(int|string $key, $value): self
    {
        $this->readOnlyCheck();
        $this->typeCheck($value);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item.
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
     * Remove an item.
     *
     * @param  int|string $key
     * @return void
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function remove(int|string $key): void
    {
        $this->readOnlyCheck();

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

            // @fix @todo: Make namespace resolution for short class names.
            if (in_array($type, $types)) {
                return;
            }

            throw new CollectionException('Each value must be type of %s, %s given',
                [$this->dataType, $type]);
        }
    }
}

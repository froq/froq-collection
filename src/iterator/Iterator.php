<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\iterator\{IteratorInterface, IteratorException};
use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait};
use froq\common\interface\{Arrayable, Jsonable};
use froq\common\trait\{DataCountTrait, DataEmptyTrait, DataListTrait, DataToArrayTrait, DataToObjectTrait,
    DataToJsonTrait, DataIteratorTrait, ReadOnlyTrait};
use froq\util\Arrays;
use Iterator as _Iterator, Countable, Traversable;

/**
 * Iterator.
 *
 * Represents an iterator class that contains some utility methods.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\Iterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class Iterator implements IteratorInterface, Arrayable, Jsonable, _Iterator, Countable
{
    /**
     * @see froq\collection\trait\SortTrait
     * @see froq\collection\trait\EachTrait
     * @see froq\collection\trait\FilterTrait
     * @see froq\collection\trait\MapTrait
     * @see froq\collection\trait\ReduceTrait
     */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait;

    /**
     * @see froq\common\trait\DataCountTrait
     * @see froq\common\trait\DataEmptyTrait
     * @see froq\common\trait\DataListTrait
     * @see froq\common\trait\DataToArrayTrait
     * @see froq\common\trait\DataToObjectTrait
     * @see froq\common\trait\DataToJsonTrait
     * @see froq\common\trait\DataIteratorTrait
     */
    use DataCountTrait, DataEmptyTrait, DataListTrait, DataToArrayTrait, DataToObjectTrait, DataToJsonTrait,
        DataIteratorTrait;

    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array */
    protected array $data;

    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     */
    public function __construct(iterable $data, bool $readOnly = null)
    {
        if ($data instanceof Traversable) {
            $data = iterator_to_array($data);
        }

        $this->data = $data;

        $this->readOnly($readOnly);
    }

    /**
     * Check whether a value exists in data array.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return bool
     */
    public function has(mixed $value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Check whether a key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Append values to data array.
     *
     * @param  mixed ...$values
     * @return self
     * @throws froq\collection\iterator\IteratorException
     */
    public function append(mixed ...$values): self
    {
        $this->readOnlyCheck();

        $values || throw new IteratorException('No values provided');

        foreach ($values as $value) {
            $this->data[] = $value;
        }

        return $this;
    }

    /**
     * Append a value to data array with given key.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     */
    public function appendAt(int|string $key, mixed $value): self
    {
        $this->readOnlyCheck();

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Reverse data array.
     *
     * @param  bool $keepKeys
     * @return self
     * @since  5.5
     */
    public function reverse(bool $keepKeys = false): self
    {
        $this->readOnlyCheck();

        $this->data = array_reverse($this->data, $keepKeys);

        return $this;
    }
}

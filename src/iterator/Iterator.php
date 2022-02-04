<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, HasTrait};
use froq\common\interface\{Listable, Arrayable, Objectable, Jsonable};
use froq\common\trait\{DataCountTrait, DataEmptyTrait, DataToListTrait, DataToArrayTrait, DataToObjectTrait,
    DataToJsonTrait, DataIteratorTrait, ReadOnlyTrait};

/**
 * Iterator.
 *
 * An iterator class that contains some utility methods.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\Iterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class Iterator implements IteratorInterface, Listable, Arrayable, Objectable, Jsonable,
    \Iterator, \Countable, \JsonSerializable
{
    /**
     * @see froq\collection\trait\SortTrait
     * @see froq\collection\trait\EachTrait
     * @see froq\collection\trait\FilterTrait
     * @see froq\collection\trait\MapTrait
     * @see froq\collection\trait\ReduceTrait
     * @see froq\collection\trait\HasTrait
     */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, HasTrait;

    /**
     * @see froq\common\trait\DataCountTrait
     * @see froq\common\trait\DataEmptyTrait
     * @see froq\common\trait\DataToListTrait
     * @see froq\common\trait\DataToArrayTrait
     * @see froq\common\trait\DataToObjectTrait
     * @see froq\common\trait\DataToJsonTrait
     * @see froq\common\trait\DataIteratorTrait
     */
    use DataCountTrait, DataEmptyTrait, DataToListTrait, DataToArrayTrait, DataToObjectTrait, DataToJsonTrait,
        DataIteratorTrait;

    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     */
    public function __construct(iterable $data, bool $readOnly = null)
    {
        if ($data) {
            if ($data instanceof \Traversable) {
                if ($data instanceof \Generator) {
                    // Prevent "Cannot rewind a generator that was already run" error.
                    $data = (new GeneratorIterator($data))
                          ->toArray();
                } else {
                    // Rewind for keys after iteration.
                    $temp = iterator_to_array($data);
                    $data->rewind();
                    $data = $temp;
                }
            }

            $this->data = $data;
        }

        $this->readOnly($readOnly);
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

        $values || throw new IteratorException('No value(s) given');

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
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}

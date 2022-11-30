<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\iterator;

/**
 * An iterator class, contains some utility methods.
 *
 * @package froq\collection\iterator
 * @class   froq\collection\iterator\Iterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class Iterator extends AbstractIterator
{
    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     */
    public function __construct(iterable $data, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Append values to data array.
     *
     * @param  mixed ...$values
     * @return self
     */
    public function append(mixed ...$values): self
    {
        $this->readOnlyCheck();

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
}

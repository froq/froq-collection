<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\iterator;

use froq\common\interface\{Arrayable, Listable};

/**
 * An extended `ArrayIterator` class.
 *
 * @package froq\collection\iterator
 * @class   froq\collection\iterator\ArrayIterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class ArrayIterator extends \ArrayIterator implements Arrayable, Listable, \JsonSerializable
{
    /**
     * @override
     */
    public function __construct(iterable $data = [])
    {
        parent::__construct(iterator_to_array($data));
    }

    /**
     * Sort.
     *
     * @param  int|null  $func
     * @param  int       $flags
     * @param  bool|null $assoc
     * @param  bool      $key
     * @return self
     */
    public function sort(callable|int $func = null, int $flags = 0, bool $assoc = null, bool $key = false): self
    {
        parent::__construct(
            sorted($this->toArray(), $func, $flags, $assoc, $key)
        );

        return $this;
    }

    /**
     * Filter items.
     *
     * @param  callable|null $func
     * @param  bool          $useKeys
     * @param  bool          $keepKeys
     * @return self
     */
    public function filter(callable $func = null, bool $useKeys = false, bool $keepKeys = true): self
    {
        parent::__construct(
            filter($this->toArray(), $func, false, $useKeys, $keepKeys)
        );

        return $this;
    }

    /**
     * Map items.
     *
     * @param  callable $func
     * @param  bool     $useKeys
     * @param  bool     $keepKeys
     * @return self
     */
    public function map(callable $func, bool $useKeys = false, bool $keepKeys = true): self
    {
        parent::__construct(
            map($this->toArray(), $func, false, $useKeys, $keepKeys)
        );

        return $this;
    }

    /**
     * Reduce.
     *
     * @param  mixed    $carry
     * @param  callable $func
     * @param  bool     $right
     * @return mixed
     */
    public function reduce(mixed $carry, callable $func, bool $right = false): mixed
    {
        return reduce($this->toArray(), $carry, $func, $right);
    }

    /**
     * Get keys.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->toArray());
    }

    /**
     * Get values.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->toArray());
    }

    /**
     * @override
     */
    public function append(mixed ...$items): void
    {
        foreach ($items as $item) {
            parent::append($item);
        }
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @inheritDoc froq\common\interface\Listable
     */
    public function toList(): array
    {
        return array_list($this->toArray());
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

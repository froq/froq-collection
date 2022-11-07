<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * A trait, provides related methods for the classes implementing `Iterator` interface.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\IteratorTrait
 * @author  Kerem Güneş
 * @since   5.10, 6.0
 */
trait IteratorTrait
{
    /** @inheritDoc Iterator */
    public function rewind(): void
    {
        reset($this->data);
    }

    /** @inheritDoc Iterator */
    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    /** @inheritDoc Iterator */
    public function next(): void
    {
        next($this->data);
    }

    /** @inheritDoc Iterator */
    public function key(): int|string|null
    {
        return key($this->data);
    }

    /** @inheritDoc Iterator */
    public function current(): mixed
    {
        return current($this->data);
    }

    /** @alias current() */
    public function value()
    {
        return $this->current();
    }

    /** @alias rewind() */
    public function reset()
    {
        $this->rewind();
    }
}

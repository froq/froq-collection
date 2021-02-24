<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\CollectionException;
use froq\common\interface\Arrayable;
use IteratorAggregate, Countable, Throwable, Generator, ReflectionMethod, ReflectionFunction;

/**
 * Iterator.
 *
 * Represents an iterator entity which is rewindable & countable.
 *
 * @package froq\collection
 * @object  froq\collection\Iterator
 * @author  Kerem Güneş
 * @since   5.0
 */
class Iterator implements IteratorAggregate, Countable, Arrayable
{
    /** @var callable */
    private $generator;

    /**
     * Constructor.
     *
     * @param callable|null $generator
     */
    public function __construct(callable $generator = null)
    {
        $generator && $this->setGenerator($generator);
    }

    /**
     * Set generator property.
     *
     * @param  callable $generator
     * @return self
     */
    public final function setGenerator(callable $generator): self
    {
        try {
            $ref = is_array($generator)
                 ? new ReflectionMethod($generator[0], $generator[1])
                 : new ReflectionFunction($generator);
        } catch (Throwable $e) {
            throw new CollectionException($e);
        }

        $ref->isGenerator() || throw new CollectionException(
            'Invalid $generator argument, given generator must execute `yield` stuff'
        );

        // Wrap in static function.
        $this->generator = static fn() => $generator;

        return $this;
    }

    /**
     * Get generator property.
     *
     * @return callable
     */
    public final function getGenerator(): callable
    {
        return $this->generator;
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public final function getIterator(): iterable
    {
        return $this->generate();
    }

    /**
     * @inheritDoc Countable
     */
    public final function count(): int
    {
        return iterator_count($this->generate());
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return iterator_to_array($this->generate());
    }

    /**
     * Run generation process.
     *
     * @return Generator
     * @internal
     */
    private function generate(): Generator
    {
        return ($this->generator)()();
    }
}

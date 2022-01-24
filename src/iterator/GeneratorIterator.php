<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\iterator\GeneratorIteratorException;
use froq\common\interface\Arrayable;
use Countable, IteratorAggregate, ReflectionMethod, ReflectionFunction, Generator;

/**
 * Generator Iterator.
 *
 * Represents a generator iterator class that is countable & reusable.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\GeneratorIterator
 * @author  Kerem Güneş
 * @since   5.0, 5.3 Moved as iterator.GeneratorIterator from Iterator.
 */
class GeneratorIterator implements Arrayable, Countable, IteratorAggregate
{
    /** @var callable */
    private $generator;

    /**
     * Constructor.
     *
     * @param callable|iterable|null $generator
     */
    public function __construct(callable|iterable $generator = null)
    {
        if ($generator) {
            if (is_callable($generator)) {
                $this->setGenerator($generator);
            } else {
                $this->setGenerator(static function () use ($generator) {
                    foreach ($generator as $current) {
                        yield $current;
                    }
                });
            }
        }
    }

    /**
     * Set generator property.
     *
     * @param  callable $generator
     * @return self
     * @throws froq\collection\iterator\GeneratorIteratorException
     */
    public final function setGenerator(callable $generator): self
    {
        try {
            $ref = is_array($generator)
                 ? new ReflectionMethod($generator[0], $generator[1])
                 : new ReflectionFunction($generator);
        } catch (\Throwable $e) {
            throw new GeneratorIteratorException($e);
        }

        $ref->isGenerator() || throw new GeneratorIteratorException(
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
     * @throws froq\collection\iterator\GeneratorIteratorException
     */
    public final function getGenerator(): callable
    {
        isset($this->generator) || throw new GeneratorIteratorException(
            'No generator was set yet, try after calling setGenerator() method'
        );

        return $this->generator;
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public final function toArray(): array
    {
        return iterator_to_array($this->generate());
    }

    /**
     * @inheritDoc Countable
     */
    public final function count(): int
    {
        return iterator_count($this->generate());
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public final function getIterator(): Generator
    {
        return $this->generate();
    }

    /**
     * Run generation process.
     *
     * @return Generator
     */
    private function generate(): Generator
    {
        return ($this->getGenerator())()();
    }
}

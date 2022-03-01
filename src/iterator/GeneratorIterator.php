<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\common\interface\{Arrayable, Listable};
use Closure, Generator;

/**
 * Generator Iterator.
 *
 * A generator iterator class which is countable & reusable.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\GeneratorIterator
 * @author  Kerem Güneş
 * @since   5.0, 5.3
 */
class GeneratorIterator implements Arrayable, Listable, \Countable, \IteratorAggregate
{
    /** @var Closure */
    private Closure $generator;

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
                $this->setGenerator(function () use ($generator) {
                    foreach ($generator as $key => $value) {
                        yield $key => $value;
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
            $ref = new \ReflectionCallable($generator);
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
     * @return Closure
     * @throws froq\collection\iterator\GeneratorIteratorException
     */
    public final function getGenerator(): Closure
    {
        isset($this->generator) || throw new GeneratorIteratorException(
            'No generator was set yet, try after calling setGenerator() method'
        );

        return $this->generator;
    }

    /**
     * Apply given action for each item & return a new modified generator iterator.
     *
     * @param  callable $func
     * @return froq\collection\iterator\GeneratorIterator
     */
    public function apply(callable $func): GeneratorIterator
    {
        $generator = function () use ($func) {
            // Prevent argument errors.
            $ref = new \ReflectionCallable($func);
            $fun = $ref->getParametersCount() > 1
                 ? static fn($value, $key) => $func($value, $key)
                 : static fn($value)       => $func($value);

            foreach ($this->generate() as $key => $value) {
                yield $key => $fun($value, $key);
            }
        };

        return new GeneratorIterator($generator);
    }

    /**
     * Apply given action for each item.
     *
     * @param  callable $func
     * @return void
     */
    public function each(callable $func): void
    {
        // Prevent argument errors.
        $ref = new \ReflectionCallable($func);
        $fun = $ref->getParametersCount() > 1
             ? static fn($value, $key) => $func($value, $key)
             : static fn($value)       => $func($value);

        foreach ($this->generate() as $key => $value) {
            $fun($value, $key);
        }
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return iterator_to_array($this->generate());
    }

    /**
     * @inheritDoc froq\common\interface\Listable
     */
    public function toList(): array
    {
        return array_values(iterator_to_array($this->generate()));
    }

    /**
     * @inheritDoc Countable
     */
    public function count(): int
    {
        return iterator_count($this->generate());
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public function getIterator(): Generator
    {
        return $this->generate();
    }

    /**
     * Run generation process.
     */
    private function generate(): Generator
    {
        return ($this->getGenerator())()();
    }
}

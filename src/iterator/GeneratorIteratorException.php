<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\iterator;

/**
 * @package froq\collection\iterator
 * @class   froq\collection\iterator\GeneratorIteratorException
 * @author  Kerem Güneş
 * @since   5.7
 */
class GeneratorIteratorException extends IteratorException
{
    public static function forInvalidGeneratorArgument(): static
    {
        return new static('Invalid $generator argument, given generator must execute "yield" stuff');
    }

    public static function forUninitializedGeneratorProperty(): static
    {
        return new static('No generator was set yet, try after calling %s::setGenerator() method',
            GeneratorIterator::class);
    }
}

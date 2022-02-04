<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\common\interface\{Listable, Arrayable, Objectable, Jsonable, Yieldable,
    Iteratable, IteratableReverse};
use froq\common\trait\{ArrayTrait, ReadOnlyTrait};

/**
 * Abstract Collator.
 *
 * An abstract collator class that used by collator classes.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\AbstractCollator
 * @author  Kerem Güneş
 * @since   5.17
 */
abstract class AbstractCollator implements CollatorInterface
{
    /** @see froq\common\trait\ArrayTrait */
    use ArrayTrait;

    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable|null $data
     * @param bool|null     $readOnly
     */
    public function __construct(iterable $data = null, bool $readOnly = null)
    {
        if ($data) {
            if ($data instanceof \Traversable) {
                if ($data instanceof \Generator) {
                    // Prevent "Cannot rewind a generator that was already run" error.
                    $data = (new iterator\GeneratorIterator($data))
                          ->toArray();
                } else {
                    // Rewind for keys after iteration.
                    $temp = iterator_to_array($data);
                    $data->rewind();
                    $data = $temp;
                }
            }

            $this->setData($data);
        }

        $this->readOnly($readOnly);
    }
}

<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\common\interface\{Listable, Arrayable, Objectable, Jsonable, Yieldable, Iteratable, IteratableReverse};
use froq\common\trait\{ArrayTrait, ReadOnlyTrait};
use froq\common\exception\InvalidKeyException;
use froq\util\Util;

/**
 * Abstract Collection.
 *
 * An abstract collection class that used by collection classes.
 *
 * @package froq\collection
 * @object  froq\collection\AbstractCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
abstract class AbstractCollection implements CollectionInterface, Listable, Arrayable, Objectable, Jsonable, Yieldable,
    Iteratable, IteratableReverse, \Iterator, \Countable, \JsonSerializable
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
     * @param  iterable|null $data
     * @param  bool|null     $readOnly
     * @causes froq\common\exception\InvalidKeyException
     */
    public function __construct(iterable $data = null, bool $readOnly = null)
    {
        if ($data) {
            if (is_iterator($data)) {
                $data = Util::makeArray($data, deep: false);
            }

            $i = 0;
            foreach ($data as $key => $value) {
                $this->keyCheck($key, $i++);
                $this->data[$key] = $value;
            }
        }

        $this->readOnly($readOnly);
    }

    /**
     * Key validity checker.
     *
     * @param  mixed    $key
     * @param  int|null $offset
     * @return void
     * @throws froq\common\exception\InvalidKeyException
     */
    protected function keyCheck(mixed $key, int $offset = null): void
    {
        if ($key === '') {
            if ($offset === null) {
                $message = 'Empty/null keys not allowed';
                $messageParams = null;
            } else {
                $message = 'Empty/null keys not allowed [offset: %s]';
                $messageParams = [$offset];
            }

            throw new InvalidKeyException($message, $messageParams);
        }

        switch (true) {
            case ($this instanceof Collection):
            case ($this instanceof TypedCollection):
            case ($this instanceof WeightedCollection):
            case ($this instanceof object\ArrayObject):
                is_int($key) || is_string($key) || throw new InvalidKeyException(
                    ($offset !== null)
                        ? 'Invalid data, data keys must be int|string [offset: %s]'
                        : 'Invalid key type, key type must be int|string'
                    , [$offset]
                );
                break;
            case ($this instanceof ItemCollection):
            case ($this instanceof object\ListObject):
                is_int($key) || throw new InvalidKeyException(
                    ($offset !== null)
                        ? 'Invalid data, data keys must be int [offset: %s]'
                        : 'Invalid key type, key type must be int'
                    , [$offset]
                );

                // Note: evaluates "'' < 0" true.
                if ($key < 0) throw new InvalidKeyException(
                    ($offset !== null)
                        ? 'Invalid data, data keys must be sequential [offset: %s]'
                        : 'Invalid key, key must be greater than or equal to 0'
                    , [$offset]
                );
        }
    }
}

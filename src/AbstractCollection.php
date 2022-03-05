<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\trait\ArrayTrait;
use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Yieldable, Iteratable, IteratableReverse};
use froq\common\{trait\ReadOnlyTrait, exception\InvalidKeyException};
use froq\util\Util;

/**
 * Abstract Collection.
 *
 * An abstract collection class, extended by collection classes.
 *
 * @package froq\collection
 * @object  froq\collection\AbstractCollection
 * @author  Kerem Güneş
 * @since   4.0, 6.0
 */
abstract class AbstractCollection implements CollectionInterface, Arrayable, Objectable, Listable, Jsonable, Yieldable,
    Iteratable, IteratableReverse, \Iterator, \Countable, \JsonSerializable
{
    /** @see froq\collection\trait\ArrayTrait */
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
            $message = ($offset === null)
                ? 'Empty/null keys not allowed'
                : 'Empty/null keys not allowed [offset: %s]';

            throw new InvalidKeyException($message, [$offset]);
        }

        switch (true) {
            case ($this instanceof Collection):
                if (!is_int($key) && !is_string($key) && !is_array($key)) {
                    $message = ($offset !== null)
                        ? 'Invalid data, data keys must be int|string|array [type: %t, offset: %s]'
                        : 'Invalid key type, key type must be int|string|array [type: %t]';

                    throw new InvalidKeyException($message, [$key, $offset]);
                }
                break;
            case ($this instanceof TypedCollection):
            case ($this instanceof WeightedCollection):
            case ($this instanceof object\ArrayObject):
                if (!is_int($key) && !is_string($key)) {
                    $message = ($offset !== null)
                        ? 'Invalid data, data keys must be int|string [type: %t, offset: %s]'
                        : 'Invalid key type, key type must be int|string [type: %t]';

                    throw new InvalidKeyException($message, [$key, $offset]);
                }
                break;
            case ($this instanceof ItemCollection):
            case ($this instanceof object\ListObject):
                if (!is_int($key)) {
                    $message = ($offset !== null)
                        ? 'Invalid data, data keys must be int [type: %t, offset: %s]'
                        : 'Invalid key type, key type must be int [type: %t]';

                    throw new InvalidKeyException($message, [$key, $offset]);
                }

                // Note: evaluates "'' < 0" true.
                if ($key < 0) {
                    $message = ($offset !== null)
                        ? 'Invalid data, data keys must be sequential [key: %s, offset: %s]'
                        : 'Invalid key, key must be greater than or equal to 0 [key: %s]';

                    throw new InvalidKeyException($message, [$key, $offset]);
                }
        }
    }
}

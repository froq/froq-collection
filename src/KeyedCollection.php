<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\collection;

use froq\util\interfaces\Loopable;

/**
 * Keyed collection.
 * @package froq\collection
 * @object  froq\collection\KeyedCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.5
 */
class KeyedCollection implements Loopable
{
    /**
     * Data
     * @var array
     */
    protected $data = [];

    /**
     * Data keys.
     * @var array
     */
    protected static $dataKeys = [];

    /**
     * Constructor.
     * @param array $dataKeys
     */
    public function __construct(array $dataKeys)
    {
        self::$dataKeys = $dataKeys;
    }

    /**
     * Get data.
     * @return array
     */
    public final function getData(): array
    {
        return $this->data;
    }

    /**
     * Get data keys.
     * @return array
     */
    public final function getDataKeys(): array
    {
        return self::$dataKeys;
    }

    /**
     * Has.
     * @param  string $key
     * @return bool
     * @throws froq\collection\CollectionException
     */
    public final function has(string $key): bool
    {
        $this->keyCheck($key);

        return isset($this->data[$key]);
    }

    /**
     * Set.
     * @param  string   $key
     * @param  any|null $value
     * @return self
     * @throws froq\collection\CollectionException
     */
    public final function set(string $key, $value): self
    {
        $this->keyCheck($key);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get.
     * @param  string $key
     * @return any|null
     * @throws froq\collection\CollectionException
     */
    public final function get(string $key)
    {
        $this->keyCheck($key);

        return $this->data[$key] ?? null;
    }

    /**
     * Key check.
     * @param  string $key
     * @param  bool   $throw
     * @return bool
     * @throws froq\collection\CollectionException
     */
    public final function keyCheck(string $key, bool $throw = true): bool
    {
        if (in_array($key, self::$dataKeys)) {
            return true;
        }
        if (!$throw) {
            return false;
        }
        throw new CollectionException(sprintf("Invalid key '%s' given, valid keys are '%s'",
            $key, join(',', self::$dataKeys)));
    }

    /**
     * @inheritDoc froq\util\interfaces\Loopable > Countable
     */
    public final function count()
    {
        return count($this->data);
    }

    /**
     * @inheritDoc froq\util\interfaces\Loopable > IteratorAggregate
     */
    public final function getIterator()
    {
        return new \ArrayIterator($this->data);
    }
}

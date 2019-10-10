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
 * SimpleCollection.
 * @package froq\collection
 * @object  froq\collection\SimpleCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   3.1
 */
class SimpleCollection implements Loopable
{
    /**
     * Items.
     * @var array
     */
    protected $items = [];

    /**
     * Constructor.
     * @param  array|null $items
     */
    public function __construct(array $items = null)
    {
        $this->items = $items ?? [];
    }

    /**
     * Item.
     * @param  int $index
     * @return any|null
     */
    public final function item(int $index)
    {
        return $this->items[$index] ?? null;
    }

    /**
     * Items.
     * @return array
     */
    public final function items(): array
    {
        return $this->items;
    }

    /**
     * Add.
     * @param  any $item
     * @return void
     */
    public final function add($item): void
    {
        $this->items[] = $item;
    }

    /**
     * Remove.
     * @param  int $index
     * @return void
     */
    public final function remove(int $index): void
    {
        unset($this->items[$index]);
    }

    /**
     * @inheritDoc froq\util\interfaces\Loopable > Countable
     */
    public final function count()
    {
        return count($this->items);
    }

    /**
     * @inheritDoc froq\util\interfaces\Loopable > IteratorAggregate
     */
    public final function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}

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

use froq\collection\ItemsException;
use Countable, IteratorAggregate, ArrayIterator;

/**
 * Items.
 *
 * Represents a simple array structure that inspired by DOMTokenList of JavaScript. @link
 * https://developer.mozilla.org/en-US/docs/Web/API/DOMTokenList
 *
 * @package froq\collection
 * @object  froq\collection\Items
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Items implements Countable, IteratorAggregate
{
    /**
     * Items.
     * @var array
     */
    protected array $items = [];

    /**
     * Constructor.
     * @param array|null $items
     */
    public function __construct(array $items = null)
    {
        if ($items != null) {
            foreach (array_keys($items) as $key) {
                if (!is_int($key)) {
                    throw new ItemsException('Only int keys accepted for '. static::class);
                }
            }
        }

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
     * Has.
     * @param  int $index
     * @return bool
     */
    public final function has(int $index): bool
    {
        return isset($this->items[$index]);
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
     * Empty.
     * @return void
     */
    public final function empty(): void
    {
        $this->items = [];
    }

    /**
     * Is empty.
     * @return bool
     */
    public final function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * @inheritDoc Countable
     */
    public final function count(): int
    {
        return count($this->items);
    }

    /**
     * @inheritDoc IteratorAggregate
     */
    public final function getIterator(): iterable
    {
        return new ArrayIterator($this->items);
    }
}

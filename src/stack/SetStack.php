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

namespace froq\collection\stack;

use froq\collection\stack\{Stack, StackException};

// '@' is just for 'Declaration of FUCK should be compatible with FUCK!'
// Shhh, covariance.. https://wiki.php.net/rfc/covariant-returns-and-contravariant-parameters
@(function() {

/**
 * Set Stack.
 *
 * This is not an implementation of https://en.wikipedia.org/wiki/Stack_(abstract_data_type) but
 * simply designed to be available to int type key check here. Inspired by HashSet of JAVA.
 * @link https://docs.oracle.com/javase/8/docs/api/java/util/HashSet.html
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\SetStack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class SetStack extends Stack
{
    /**
     * Constructor.
     * @param  array<int, any>|null $data
     * @throws froq\collection\stack\StackException
     * @override
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            foreach (array_keys($data) as $key) {
                if (!is_int($key)) {
                    throw new StackException('Only int keys are accepted for '. static::class);
                }
            }

            parent::__construct($data, true);
        }
    }

    /**
     * Has.
     * @param  int $key
     * @return bool
     * @override
     */
    public final function has(int $key): bool
    {
        return parent::has($key);
    }

    /**
     * Has key.
     * @param  int $key
     * @return bool
     * @override
     */
    public final function hasKey(int $key): bool
    {
        return parent::hasKey($key);
    }

    /**
     * Set.
     * @param  int $key
     * @param  any $value
     * @return self
     * @override
     */
    public final function set(int $key, $value): self
    {
        return parent::set($key, $value);
    }

    /**
     * Get.
     * @param  int      $key
     * @param  any|null $valueDefault
     * @return any
     * @override
     */
    public final function get(int $key, $valueDefault = null)
    {
        return parent::get($key, $valueDefault);
    }

    /**
     * Add.
     * @param  int $key
     * @param  any  $value
     * @return self
     * @override
     */
    public final function add(int $key, $value): self
    {
        return parent::add($key, $value);
    }

    /**
     * Remove.
     * @param  int $key
     * @return void
     * @override
     */
    public final function remove(int $key): void
    {
        parent::remove($key);
    }
}

})();

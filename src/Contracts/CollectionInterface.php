<?php

namespace Avoxx\Support\Contracts;

/*
 * AVOXX - PHP Framework Packages
 *
 * @author    Merlin Christen <merloxx@avoxx.org>
 * @copyright Copyright (c) 2016 Merlin Christen
 * @license   The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

interface CollectionInterface
{
    /**
     * Set a new collection item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * Return an item from the collection.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Determine if an item exists in the collection by key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Return all collection items.
     *
     * @return array
     */
    public function all();

    /**
     * Return the first collection item.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function first($default = null);

    /**
     * Return the last collection item.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function last($default = null);

    /**
     * Return the collection keys.
     *
     * @return static
     */
    public function keys();

    /**
     * Remove an item from the collection.
     *
     * @param string $key
     */
    public function remove($key);

    /**
     * Add an item to the collection.
     *
     * @param array $data
     */
    public function replace(array $data);

    /**
     * Remove all items from the collection.
     */
    public function clear();
}

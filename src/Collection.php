<?php

namespace Avoxx\Support;

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
use ArrayIterator;
use Avoxx\Support\Contracts\CollectionInterface;

class Collection extends ArrayIterator implements CollectionInterface
{
    /**
     * The collection source data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new collection instance.
     *
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        $this->data = $this->getArrayableItems($data);
    }

    /**
     * Set a new collection item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Return an item from the collection.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->data[$key] : $default;
    }

    /**
     * Determine if an item exists in the collection.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Return all collection items.
     *
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * Return the first collection item.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function first($default = null)
    {
        return reset($this->data) ?: $default;
    }

    /**
     * Return the last collection item.
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function last($default = null)
    {
        $last = array_reverse($this->data);

        return reset($last) ?: $default;
    }

    /**
     * Return the collection keys.
     *
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->data));
    }

    /**
     * Return the number of collection items.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Remove an item from the collection.
     *
     * @param string $key
     */
    public function remove($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Replace a collection item.
     *
     * @param array $data
     */
    public function replace(array $data)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Remove all items from the collection.
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Determine if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * Execute a callback over each collection item.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this->data as $key => $value) {
            $callback($value, $key);
        }

        return $this;
    }

    /**
     * Run a filter over each collection item.
     *
     * @param callable|null $callback
     *
     * @return static
     */
    public function filter(callable $callback = null)
    {
        if ($callback) {
            return new static(array_filter($this->data, $callback));
        }

        return new static(array_filter($this->data));
    }

    /**
     * Run a map over each collection item.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = $this->keys()->all();
        $data = array_map($callback, $this->data, $keys);

        return new static(array_combine($keys, $data));
    }

    /**
     * Merge the collection with the given items.
     *
     * @param mixed $data
     *
     * @return static
     */
    public function merge($data)
    {
        return new static(array_merge($this->data, $this->getArrayableItems($data)));
    }

    /**
     * Return all items in the collection as a JSON string.
     *
     * @param int $options
     * @param int $depth
     *
     * @return string
     */
    public function toJson($options = 0, $depth = 512)
    {
        return json_encode($this->data, $options, $depth);
    }

    /**
     * Return all items in the collection as a JSON string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Return a collection item at a given offset.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set a new collection item at a given offset.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Remove an item from the collection at a given offset.
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /**
     * Return the collection array iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Return all items from a collection instance or array.
     *
     * @param mixed $data
     *
     * @return array
     */
    protected function getArrayableItems($data)
    {
        if ($data instanceof self) {
            return $data->all();
        }

        return (array) $data;
    }
}

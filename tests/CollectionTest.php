<?php

namespace Avoxx\Support\Collection\Test;

use Avoxx\Support\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $collection = new Collection('foo');
        $this->assertSame(['foo'], $collection->all());

        $collection = new Collection(1);
        $this->assertSame([1], $collection->all());

        $collection = new Collection(false);
        $this->assertSame([false], $collection->all());

        $collection = new Collection(null);
        $this->assertSame([], $collection->all());

        $collection = new Collection();
        $this->assertSame([], $collection->all());
    }

    public function testSetAndGet()
    {
        $collection = new Collection();
        $collection->set('foo', 'bar');

        $this->assertEquals('bar', $collection->get('foo'));
        $this->assertSame(['foo' => 'bar'], $collection->all());
    }

    public function testGetDefault()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertNull($collection->get('baz'));
        $this->assertEquals('qux', $collection->get('baz', 'qux'));
    }

    public function testHas()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertTrue($collection->has('foo'));
        $this->assertFalse($collection->has('baz'));
    }

    public function testAll()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $collection->all());
    }

    public function testFirst()
    {
        $collection = new Collection(['foo' => 'bar', 'baz' => 'qux']);

        $this->assertEquals('bar', $collection->first());
    }

    public function testFirstWithDefaultValue()
    {
        $collection = new Collection();

        $this->assertEquals('default', $collection->first('default'));
    }

    public function testLast()
    {
        $collection = new Collection(['foo' => 'bar', 'baz' => 'qux']);
        $this->assertEquals('qux', $collection->last());
    }

    public function testLastWithDefaultValue()
    {
        $collection = new Collection();
        $this->assertEquals('default', $collection->last('default'));
    }

    public function testKeys()
    {
        $collection = new Collection(['foo' => 'bar', 'baz' => 'qux']);

        $this->assertEquals(['foo', 'baz'], $collection->keys()->all());
    }

    public function testCount()
    {
        $collection = new Collection(['foo', 'bar']);

        $this->assertEquals(2, $collection->count());
    }

    public function testRemove()
    {
        $collection = new Collection(['foo', 'bar']);
        $collection->remove('foo');

        $this->assertNull($collection->get('foo'));
    }

    public function testReplace()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection->replace(['foo' => 'replaced']);

        $this->assertSame(['foo' => 'replaced'], $collection->all());
    }

    public function testClear()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection->clear();

        $this->assertEmpty($collection->all());
    }

    public function testIsEmpty()
    {
        $collection = new Collection(['foo', 'bar']);
        $this->assertFalse($collection->isEmpty());

        $collection = new Collection();
        $this->assertTrue($collection->isEmpty());
    }

    public function testEach()
    {
        $collection = new Collection(['foo' => 'bar']);

        $result = [];
        $collection->each(function ($value, $key) use (&$result) {
            $result[$key] = $value;
        });

        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testFilter()
    {
        $collection = new Collection([['id' => 1], ['id' => 2]]);

        $result = $collection->filter(function ($data) {
            return $data['id'] == 1;
        })->all();

        $this->assertEquals([0 => ['id' => 1]], $result);
        $this->assertEquals([0 => ['id' => 1], 1 => ['id' => 2]], $collection->filter()->all());
    }

    public function testMap()
    {
        $collection = new Collection(['foo', 'bar']);

        $result = $collection->map(function ($value, $key) {
            return $key.' - '.$value;
        });

        $this->assertEquals([0 => '0 - foo', 1 => '1 - bar'], $result->all());
    }

    public function testMerge()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $collection->merge(null)->all());

        $collection = new Collection(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'qux'], $collection->merge(['bar' => 'qux'])->all());

        $collection = new Collection(['foo' => 'bar']);
        $collection2 = new Collection(['bar' => 'qux']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'qux'], $collection->merge($collection2)->all());
    }

    public function testToJson()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertEquals('{"foo":"bar"}', $collection->toJson());
    }

    public function testToString()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertEquals('{"foo":"bar"}', $collection);
    }

    public function testOffsetAccess()
    {
        $collection = new Collection(['foo' => 'bar']);
        $this->assertEquals('bar', $collection['foo']);

        $collection['foo'] = 'bar';
        $this->assertEquals('bar', $collection['foo']);

        unset($collection['foo']);
        $this->assertFalse(isset($collection['foo']));
    }

    public function testOffsetExists()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertTrue($collection->offsetExists('foo'));
        $this->assertFalse($collection->offsetExists('baz'));
    }

    public function testOffsetGet()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertEquals('bar', $collection->offsetGet('foo'));
    }

    public function testOffsetSet()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection->offsetSet('baz', 'qux');

        $this->assertEquals('qux', $collection['baz']);
    }

    public function testOffsetUnset()
    {
        $collection = new Collection(['foo' => 'bar']);
        $collection->offsetUnset('foo');

        $this->assertEmpty($collection['foo']);
    }

    public function testGetIterator()
    {
        $collection = new Collection(['foo' => 'bar']);

        $this->assertInstanceOf('ArrayIterator', $collection->getIterator());
        $this->assertEquals(['foo' => 'bar'], $collection->getIterator()->getArrayCopy());
    }
}

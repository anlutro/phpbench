<?php
class CallbackTest extends PHPUnit_Framework_TestCase
{
	public function testStaticMethodCallable()
	{
		$c = $this->makeCallback(['Foo', 'psf']);

		$this->assertTrue($c->isStaticMethod());
		$this->assertFalse($c->isObjectMethod());
		$this->assertFalse($c->isClosure());
		$this->assertFalse($c->isFunction());

		$this->assertEquals('psf', $c());
	}

	public function testMethodCallable()
	{
		$c = $this->makeCallback(['Foo', 'pf']);
		$this->assertFalse($c->isStaticMethod());
		$this->assertTrue($c->isObjectMethod());
		$this->assertFalse($c->isClosure());
		$this->assertFalse($c->isFunction());

		$this->assertEquals('pf', $c());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonPublicMethod()
	{
		$c = $this->makeCallback(['Foo', 'prf']);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonPublicStaticMethod()
	{
		$c = $this->makeCallback(['Foo', 'prsf']);
	}

	public function testClosureCallable()
	{
		$cl = function() { return 'closure'; };
		$c = $this->makeCallback($cl);

		$this->assertFalse($c->isStaticMethod());
		$this->assertFalse($c->isObjectMethod());
		$this->assertTrue($c->isClosure());
		$this->assertFalse($c->isFunction());

		$this->assertEquals('closure', $c());
	}

	public function testFunctionCallable()
	{
		$c = $this->makeCallback('bar');

		$this->assertFalse($c->isStaticMethod());
		$this->assertFalse($c->isObjectMethod());
		$this->assertFalse($c->isClosure());
		$this->assertTrue($c->isFunction());

		$this->assertEquals('bar', $c());
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonexistantFunctionCallable()
	{
		$c = $this->makeCallback('baz');
	}

	public function makeCallback($callable)
	{
		return new anlutro\PHPBench\Reflection\Callback($callable);
	}
}

class Foo {
	public function pf() { return 'pf'; }
	public static function psf() { return 'psf'; }
	protected function prf() { return 'prf'; }
	protected static function prsf() { return 'prsf'; }
}

function bar() { return 'bar'; }

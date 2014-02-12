<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

class CallbackTest extends PHPUnit_Framework_TestCase
{
	public function testStaticMethodCallable()
	{
		$c = $this->makeCallback(array('CallbackTestBasicStub', 'psf'));

		$this->assertTrue($c->isStaticMethod());
		$this->assertFalse($c->isObjectMethod());
		$this->assertFalse($c->isClosure());
		$this->assertFalse($c->isFunction());

		$this->assertEquals('psf', $c());
	}

	public function testMethodCallable()
	{
		$c = $this->makeCallback(array('CallbackTestBasicStub', 'pf'));
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
		$c = $this->makeCallback(array('CallbackTestBasicStub', 'prf'));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testNonPublicStaticMethod()
	{
		$c = $this->makeCallback(array('CallbackTestBasicStub', 'prsf'));
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

	public function testSetupAndTeardownAreCalled()
	{
		$c = $this->makeCallback(array('CallbackTestPrePostStub', 'f'));
		
		$c->setUp();
		$c->invoke();
		$c->tearDown();

		$this->assertTrue(CallbackTestPrePostStub::$setUp);
		$this->assertTrue(CallbackTestPrePostStub::$tearDown);
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

class CallbackTestBasicStub {
	public function pf() { return 'pf'; }
	public static function psf() { return 'psf'; }
	protected function prf() { return 'prf'; }
	protected static function prsf() { return 'prsf'; }
}
class CallbackTestPrePostStub {
	public static $setUp = false;
	public static $tearDown = false;
	public function setUp()
	{
		static::$setUp = true;
	}
	public function tearDown()
	{
		static::$tearDown = true;
	}
	public function f() {}
}

function bar() { return 'bar'; }

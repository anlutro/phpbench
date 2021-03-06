<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

use Mockery as m;

class BenchClassReflectorTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testReflectorGetsMethods()
	{
		$refl = $this->makeReflector('SomeClassStub');
		$expected = array(
			$this->makeCallback(array('SomeClassStub', 'benchFoo')),
			$this->makeCallback(array('SomeClassStub', 'benchBar')),
		);
		$this->assertEquals($expected, $refl->getBenchCallables());
	}

	public function testReflectorGetsAnnotations()
	{
		$antreader = $this->makeMockAnnotationsReader(array(), array('SomeAnnotation'));
		$refl = $this->makeReflector('SomeClassStub', $antreader);
		$expected = array(
			$this->makeCallback(array('SomeClassStub', 'benchFoo'), array('SomeAnnotation')),
			$this->makeCallback(array('SomeClassStub', 'benchBar'), array('SomeAnnotation')),
		);
		$this->assertEquals($expected, $refl->getBenchCallables());
	}

	protected function makeReflector($class, $reader = null)
	{
		if ($reader === null) $reader = $this->makeMockAnnotationsReader();
		return new anlutro\PHPBench\Reflection\BenchClassReflector($class, $reader);
	}

	protected function makeMockAnnotationsReader($class = array(), $method = array())
	{
		$mock = m::mock('Doctrine\Common\Annotations\AnnotationReader');
		$mock->shouldReceive('getClassAnnotations')->andReturn($class);
		$mock->shouldReceive('getMethodAnnotations')->andReturn($method);
		return $mock;
	}

	public function makeCallback($callable, $annotations = array())
	{
		return new anlutro\PHPBench\Reflection\Callback($callable, $annotations);
	}
}

class SomeClassStub
{
	public function benchFoo() {}
	public function benchBar() {}
	public function notBenchBaz() {}
}

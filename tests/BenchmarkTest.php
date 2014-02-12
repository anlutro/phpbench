<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

use Mockery as m;

class BenchmarkTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testBenchmarkDefaultValues()
	{
		$callable = $this->makeMockCallable();
		$callable->shouldReceive('getAnnotations')->andReturn(array());
		$callable->shouldReceive('getStringRepresentation')->andReturn('foo');
		$bench = $this->makeBenchmark($callable);

		$this->assertEquals('foo', $bench->getCallableString());
		$this->assertEquals(1, $bench->getIterations());
	}

	public function testBenchmarkInvokesCallback()
	{
		$callable = $this->makeMockCallable();
		$callable->shouldReceive('getAnnotations')->andReturn(array());
		$callable->shouldReceive('setUp')->once();
		$callable->shouldReceive('invoke')->once();
		$callable->shouldReceive('tearDown')->once();
		$bench = $this->makeBenchmark($callable);

		$bench->run();
	}

	public function testBenchmarkIterations()
	{
		$callable = $this->makeMockCallable();
		$callable->shouldReceive('getAnnotations')->andReturn(array());
		$callable->shouldReceive('setUp')->once();
		$callable->shouldReceive('invoke')->times(5);
		$callable->shouldReceive('tearDown')->once();
		$bench = $this->makeBenchmark($callable);
		$bench->setIterations(5);

		$bench->run();
	}

	protected function makeBenchmark($callable)
	{
		return new anlutro\PHPBench\Benchmark\Benchmark($callable);
	}

	protected function makeMockCallable()
	{
		return m::mock('anlutro\PHPBench\Reflection\Callback');
	}
}

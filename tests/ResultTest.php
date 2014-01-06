<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

use Mockery as m;

class ResultTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testElapsedString()
	{
		$benchmark = $this->makeMockBenchmark();
		$result = $this->makeResult($benchmark, 1);

		$this->assertEquals('1.00 seconds', $result->getElapsedString());
	}

	protected function makeMockBenchmark()
	{
		return m::mock('anlutro\PHPBench\Benchmark\Benchmark');
	}

	protected function makeResult($bench, $elapsed)
	{
		return new anlutro\PHPBench\Benchmark\Result($bench, $elapsed);
	}
}

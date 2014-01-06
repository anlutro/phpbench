<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

use Mockery as m;

class BenchmarkRunnerTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}

	public function testRunnerInvokesBenchmarks()
	{
		$bench = $this->makeMockBenchmark();
		$bench->shouldReceive('run')->once();

		$runner = $this->makeRunner(array($bench));
		$runner->run();
	}

	protected function makeMockBenchmark()
	{
		return m::mock('anlutro\PHPBench\Benchmark\Benchmark');
	}

	public function makeRunner(array $benchmarks)
	{
		return new anlutro\PHPBench\Benchmark\Runner($benchmarks);
	}
}

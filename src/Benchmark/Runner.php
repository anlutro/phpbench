<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Benchmark;

class Runner
{
	public function __construct(array $benches)
	{
		$this->benches = $benches;
	}

	public function getBenchmarks()
	{
		return $this->benches;
	}

	public function run()
	{
		$results = array();

		foreach ($this->benches as $bench) {
			$results[] = $bench->run();
		}

		return $results;
	}
}

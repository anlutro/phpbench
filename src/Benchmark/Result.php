<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Benchmark;

use anlutro\PHPBench\Reflection\Callback;

class Result
{
	protected $benchmark;
	protected $elapsed;

	public function __construct(Benchmark $benchmark, $elapsed)
	{
		$this->benchmark = $benchmark;
		$this->elapsed = $elapsed;
	}

	public function getElapsedString()
	{
		$elapsed = number_format($this->elapsed, 2);
		return $elapsed . ' seconds';
	}

	public function __toString()
	{
		return $this->getElapsedString();
	}
}

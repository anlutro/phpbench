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
use anlutro\PHPBench\Annotations\Iterations;

class Benchmark
{
	protected $callback;
	protected $iterations = 1;

	public function __construct(Callback $callback)
	{
		$this->callback = $callback;
		$this->parseAnnotations();
	}

	public function getCallableString()
	{
		return $this->callback->getStringRepresentation();
	}

	public function getIterations()
	{
		return (int) $this->iterations;
	}

	public function run()
	{
		$start = microtime(true);

		$this->invokeCallback();

		$end = microtime(true);

		$elapsed = $end - $start;

		return $this->makeResult($elapsed);
	}

	public function parseAnnotations()
	{
		$annotations = $this->callback->getAnnotations();
		foreach ($annotations as $annotation) {
			if ($annotation instanceof Iterations) {
				$this->iterations = $annotation->getNumIterations();
			}
		}
	}

	public function invokeCallback()
	{
		for ($i=0; $i < $this->iterations; $i++) { 
			$this->callback->invoke();
		}
	}

	public function makeResult($elapsed)
	{
		return new Result($this, $elapsed);
	}
}

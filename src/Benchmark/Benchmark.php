<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Benchmark;

class Benchmark
{
	public function __construct($callable)
	{
		$this->callable = $callable;
	}

	public function getCallableString()
	{
		if (is_array($this->callable)) {
			list($class, $method) = $this->callable;
			return "$class::$method";
		} elseif ($this->callable instanceof \Closure) {
			return 'Closure';
		} else {
			return (string) $this->callable;
		}
	}

	public function run()
	{
		$start = microtime(true);

		$this->callCallable();

		$end = microtime(true);

		$elapsed = $end - $start;

		return $this->makeResult($elapsed);
	}

	public function callCallable()
	{
		if (is_array($this->callable)) {
			list($class, $method) = $this->callable;
			$obj = new $class;

			if (!is_object($obj)) {
				throw new \RuntimeException('$obj is not an object');
			}

			if (!is_callable([$obj, $method])) {
				throw new \RuntimeException(get_class($obj) . '::' . $method . ' is not callable');
			}

			call_user_func([$obj, $method]);
		} else {
			call_user_func($this->callable);
		}
	}

	public function makeResult($elapsed)
	{
		return new Result($this->callable, $elapsed);
	}
}

<?php
use anlutro\PHPBench\Annotations;

class ExampleBenchmark
{
	/**
	 * @Annotations\Iterations(500000)
	 */
	public function benchStrReplace()
	{
		$str = 'adsdf';
		$str = str_replace('a', 'b', $str);
		$str = str_replace('b', 'a', $str);
		$str = str_replace('a', 'b', $str);
		$str = str_replace('b', 'a', $str);
		$str = str_replace('s', 'g', $str);
		$str = str_replace('d', 't', $str);
		$str = str_replace('f', 'n', $str);
	}

	/**
	 * @Annotations\Iterations(500000)
	 */
	public function benchReflection()
	{
		$class = new ReflectionClass($this);
		foreach ($class->getMethods() as $method) {
			// do nothing
		}
	}
}

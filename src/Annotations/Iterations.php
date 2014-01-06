<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Annotations;

use anlutro\PHPBench\Benchmark\Benchmark;

/**
 * @Annotation
 */
class Iterations implements AnnotationInterface
{
	protected $iterations;

	public function __construct($values)
	{
		$this->iterations = (int) $values['value'];
	}

	public function invoke(Benchmark $benchmark)
	{
		$benchmark->setIterations($this->iterations);
	}
}

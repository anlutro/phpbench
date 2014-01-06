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
 * Interface that benchmark annotations must implement.
 */
interface AnnotationInterface
{
	/**
	 * Invoke the annotation. In this method you can manipulate the Benchmark
	 * object as you wish.
	 *
	 * @param  Benchmark $benchmark
	 *
	 * @return void
	 */
	public function invoke(Benchmark $benchmark);
}

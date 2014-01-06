<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Reflection;

use ReflectionClass;
use ReflectionMethod;

class BenchClassReflector
{
	protected $refl;

	public function __construct($class)
	{
		$this->refl = new ReflectionClass($class);
	}

	public function getBenchCallables()
	{
		$rmethods = $this->refl->getMethods(ReflectionMethod::IS_PUBLIC);
		$methods = [];

		foreach ($rmethods as $method) {
			if (substr($method->name, 0, 5) === 'bench') {
				$methods[] = array($method->class, $method->name);
			}
		}

		return $methods;
	}
}

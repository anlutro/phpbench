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
	protected $annotationReader;

	public function __construct($class, $annotationReader)
	{
		$this->refl = new ReflectionClass($class);
		$this->annotationReader = $annotationReader;
	}

	public function getBenchCallables()
	{
		// @todo what to do with these?
		$classAnnotations = $this->annotationReader->getClassAnnotations($this->refl);

		$rmethods = $this->refl->getMethods(ReflectionMethod::IS_PUBLIC);
		$callbacks = array();

		foreach ($rmethods as $method) {
			if (substr($method->name, 0, 5) === 'bench') {
				$annotations = $this->annotationReader->getMethodAnnotations($method);
				$callable = array($method->class, $method->name);
				$callback = new Callback($callable, $annotations);

				$callbacks[] = $callback;
			}
		}

		return $callbacks;
	}
}

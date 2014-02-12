<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Reflection;

class Callback
{
	protected $class;
	protected $instance;
	protected $method;
	protected $staticMethod;
	protected $closure;
	protected $function;
	protected $annotations;

	public function __construct($callable, array $annotations = array())
	{
		if (is_array($callable)) {
			list($this->class, $method) = $callable;
			$reflMethod = new \ReflectionMethod($this->class, $method);
			if (!$reflMethod->isPublic()) {
				throw new \InvalidArgumentException('Class method must be public');
			} elseif ($reflMethod->isStatic()) {
				$this->staticMethod = $method;
			} else {
				$this->method = $method;
				$class = $this->class;
				$this->instance = new $class;
			}
		} elseif ($callable instanceof \Closure) {
			$this->closure = $callable;
		} elseif (is_string($callable)) {
			if (!function_exists($callable)) {
				throw new \InvalidArgumentException('Function does not exist');
			}

			$this->function = $callable;
		} else {
			throw new \InvalidArgumentException('Invalid callable type');
		}

		$this->annotations = $annotations;
	}

	public function getAnnotations()
	{
		return $this->annotations;
	}

	public function setUp()
	{
		if ($this->instance && method_exists($this->instance, 'setUp')) {
			$this->instance->setUp();
		}
	}

	public function tearDown()
	{
		if ($this->instance && method_exists($this->instance, 'tearDown')) {
			$this->instance->tearDown();
		}
	}

	public function invoke()
	{
		if ($this->isStaticMethod()) {
			$class = $this->class;
			$method = $this->staticMethod;
			return $class::$method();
		} elseif ($this->isObjectMethod()) {
			if (!$this->instance) {
				$class = $this->class;
				$this->instance = new $class;
			}
			$method = $this->method;
			return $this->instance->$method();
		} elseif ($this->isClosure()) {
			$closure = $this->closure;
			return $closure();
		} elseif ($this->isFunction()) {
			return call_user_func($this->function);
		}
	}

	public function isStaticMethod()
	{
		return (
			$this->class !== null &&
			$this->method === null &&
			$this->staticMethod !== null
		);
	}

	public function isObjectMethod()
	{
		return (
			$this->class !== null &&
			$this->method !== null &&
			$this->staticMethod === null
		);
	}

	public function isClosure()
	{
		return $this->closure !== null;
	}

	public function isFunction()
	{
		return $this->function !== null;
	}

	public function getStringRepresentation()
	{
		if ($this->isStaticMethod() || $this->isObjectMethod()) {
			$class = $this->class;
			$method = $this->method ?: $this->staticMethod . ' (static)';
			return "$class::$method";
		} elseif ($this->isClosure()) {
			return 'Closure';
		} elseif ($this->isFunction()) {
			return $this->function;
		}
	}

	public function __invoke()
	{
		return $this->invoke();
	}

	public function __toString()
	{
		return $this->getStringRepresentation();
	}
}

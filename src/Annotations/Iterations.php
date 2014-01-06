<?php
namespace anlutro\PHPBench\Annotations;

/**
 * @Annotation
 */
class Iterations
{
	protected $iterations;

	public function __construct($values)
	{
		$this->iterations = (int) $values['value'];
	}

	public function getNumIterations()
	{
		return $this->iterations;
	}
}
<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Console;

use Symfony\Component\Console\Command\Command as BaseCommand;

abstract class Command extends BaseCommand
{
	protected function resolve($name)
	{
		$container = $this->getContainer();
		return $container[$name];
	}

	protected function getContainer()
	{
		return $this->getApplication()->getContainer();
	}
}

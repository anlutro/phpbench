<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\HelpCommand;
use anlutro\PHPBench\PHPBench;

class Application extends BaseApplication
{
	private $container;

	public function __construct()
	{
		error_reporting(-1);
		parent::__construct('PHPBench', PHPBench::VERSION);

		$this->add(new BenchmarkCommand);
	}

	public function setContainer($container)
	{
		$this->container = $container;
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function getDefaultCommands()
	{
		return array(new HelpCommand);
	}

	public function getCommandName(InputInterface $input)
	{
		$name = parent::getCommandName($input);

		if (!$name || substr($name, 0, 1) === '-') {
			$name = 'bench';
		}

		return $name;
	}

	protected function getDefaultInputDefinition()
	{
		return new InputDefinition(array(
			new InputArgument('command', InputArgument::OPTIONAL, 'The command to execute', 'bench'),
			// new InputOption('--help',           '-h', InputOption::VALUE_NONE, 'Display this help message.'),
			// new InputOption('--quiet',          '-q', InputOption::VALUE_NONE, 'Do not output any message.'),
			// new InputOption('--verbose',        '-v|vv|vvv', InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'),
			new InputOption('--version',        '-V', InputOption::VALUE_NONE, 'Display this application version.'),
			// new InputOption('--ansi',           '',   InputOption::VALUE_NONE, 'Force ANSI output.'),
			// new InputOption('--no-ansi',        '',   InputOption::VALUE_NONE, 'Disable ANSI output.'),
			// new InputOption('--no-interaction', '-n', InputOption::VALUE_NONE, 'Do not ask any interactive question.'),
		));
	}

	public function getLongVersion()
	{
		return parent::getLongVersion() . ' by <comment>Andreas Lutro</comment>';
	}
}

<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use anlutro\PHPBench\Benchmark\Runner;
use anlutro\PHPBench\Benchmark\Benchmark;
use anlutro\PHPBench\Reflection\BenchClassReflector;

class BenchmarkCommand extends Command
{
	public function configure()
	{
		$this->setName('bench')
			->setDescription('Runs any benchmarks found.')
			->setHelp('TODO')
			->addArgument('path', InputArgument::OPTIONAL, 'Path of benchmark files.', getcwd() . '/bench');
	}

	public function execute(InputInterface $in, OutputInterface $out)
	{
		$this->out = $out;

		$path = $in->getArgument('path');

		$out->writeln('Looking for benchmarks in ' . $path);

		$classes = $this->getClasses($path);

		if (empty($classes)) {
			$out->writeln('No classes found in ' . $path);
			exit(1);
		}

		$benchmarks = $this->getBenchmarks($classes);

		if (empty($benchmarks)) {
			$out->writeln('No benchmarks found in ' . $path);
			exit(1);
		}

		$results = $this->runBenchmarks($benchmarks);
	}

	public function getClasses($path)
	{
		$classes = [];

		foreach ($this->getFiles($path) as $file) {
			$filename = $file->getFileName();
			$classname = str_replace('.php', '', $filename);
			$path = $file->getPathName();

			if (!class_exists($classname)) {
				require_once $path;
			}

			$classes[] = $classname;
		}

		return $classes;
	}

	public function getFiles($path)
	{
		$finder = $this->resolve('file.finder');
		return $finder->in($path)
			->name('*.php')
			->files();
	}

	public function getBenchmarks(array $classes)
	{
		$benchmarks = [];

		foreach ($classes as $class) {
			$refl = new BenchClassReflector($class);

			foreach ($refl->getBenchCallables() as $callable) {
				$benchmarks[] = new Benchmark($callable);
			}
		}

		return $benchmarks;
	}

	public function runBenchmarks(array $benchmarks)
	{
		$runner = new Runner($benchmarks);

		foreach ($runner->getBenchmarks() as $bench) {
			$this->out->write($bench->getCallableString() . '... ');
			$result = $bench->run();
			$this->out->write($result->getElapsedString() . PHP_EOL);
		}
	}
}

<?php
/**
 * PHPBench - PHP Benchmarking Framework
 *
 * @author    Andreas Lutro <anlutro@gmail.com>
 * @license   http://opensource.org/licenses/MIT
 * @package   phpbench
 */

namespace anlutro\PHPBench;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Pimple;

class PHPBench extends Pimple
{
	const VERSION = '0.0.1';

	public function __construct()
	{
		$this['console.application'] = $this->share(function() {
			$app = new Console\Application;
			$app->setContainer($this);
			return $app;
		});

		$this['file.system'] = $this->share(function() {
			return new Filesystem;
		});

		$this['file.finder'] = $this->share(function() {
			return new Finder;
		});

		$this['annotations.reader'] = $this->share(function() {
			foreach (glob(__DIR__ . '/Annotations/*.php') as $file) {
				AnnotationRegistry::registerFile($file);
			}
			
			$reader = new AnnotationReader;
			// $reader->setDefaultAnnotationNamespace('anlutro\\PHPBench\\Annotations\\');
			return $reader;
		});
	}

	public static function main()
	{
		$app = new static;
		$app['console.application']->run();
	}
}

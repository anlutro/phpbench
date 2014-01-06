<?php
namespace anlutro\PHPBench;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
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
	}

	public static function main()
	{
		$app = new static;
		$app['console.application']->run();
	}
}

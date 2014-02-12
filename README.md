# PHPBench [![Build Status](https://travis-ci.org/anlutro/phpbench.png?branch=master)](https://travis-ci.org/anlutro/phpbench)
## PHP Benchmarking Framework

In early development stages. Nothing to be considered stable.

Inspired by PHPUnit, aimed to provide a simple way to measure PHP code's performance.

### Usage
Install the package via composer and run `./vendor/bin/phpbench`. This file scans {current working directory]/bench/ for files ending in Bench.php (classes must be named the same as the file) and runs all public methods beginning with "bench", providing output on the time it took.

You can control the number of iterations yourself by doing a for loop or use an annotation as shown in [the example](https://github.com/anlutro/phpbench/blob/master/bench/ExampleBenchmark.php).

### Contact
Open an issue on GitHub if you have any problems or suggestions.

### License
The contents of this repository is released under the [MIT license](http://opensource.org/licenses/MIT).

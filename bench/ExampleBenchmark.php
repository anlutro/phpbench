<?php
class ExampleBenchmark
{
	public function benchStrReplace()
	{
		for($i = 0; $i < 500000; $i++) {
			$str = 'adsdf';
			$str = str_replace('a', 'b', $str);
			$str = str_replace('b', 'a', $str);
			$str = str_replace('a', 'b', $str);
			$str = str_replace('b', 'a', $str);
			$str = str_replace('s', 'g', $str);
			$str = str_replace('d', 't', $str);
			$str = str_replace('f', 'n', $str);
		}
	}

	public function benchReflection()
	{
		for ($i=0; $i < 500000; $i++) { 
			$class = new ReflectionClass($this);
			foreach ($class->getMethods() as $method) {
				// do nothing
			}
		}
	}
}

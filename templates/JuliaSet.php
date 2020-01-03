<?php

(function() use ($arguments){

	require_once("./classes/Complex.php");

	$const = new Complex(
		rand(1, 10 ** 5) / (10 ** 5), 
		rand(1, 10 ** 5) / (10 ** 5)
	);
	$iterations = mt_rand(5,15);

	$this->caption->add('f(z)=z²+' . $const );
	$this->caption->add("iterations: $iterations");

	$r = (1 + sqrt(1 + 4 * $const->abs() )) / 2; // radius 
	
	$colors = [];
	for($i=1; $i <= $iterations; $i++){
		$colors[$iterations-$i] = new Color(
			$this->canvas,
			$this->main_color->r(),
			$this->main_color->g(),
			$this->main_color->b(),
			round(127 / $iterations * $i)
		);
	}

	$f = function($c) use ($const){
		return $c->multiply($c)->add($const);
	};

	for ($i = 0; $i < $this->size; $i++) {
		for ($j = 0; $j < $this->size; $j++) {
			$point = new Complex(
				$r * (2 * $i / $this->size - 1),
				$r * (2 * $j / $this->size - 1)
			);
			for ($k = 0; $k < $iterations; $k++) {
				$point = $f($point);
				if($point->abs() > $r){
					if($k != 0)
						imagesetpixel(
							$this->canvas,
							$i,
							$j,
							$colors[$k]->get()
						);
					break;
				}
			}
		}
	}

})();

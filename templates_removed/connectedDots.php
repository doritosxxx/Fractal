<?php
/*
	arguments: count
*/

(function() use ($arguments){
	if(isset($arguments['count']))
		$count = $arguments['count'];
	else 
		$count	= mt_rand(4,15);
	
	require_once("./classes/Point.php");
	
	$points = [];
	for($i=0; $i<$count; $i++)
		$points[$i] = new Point(
			rand(0, $this->size),
			rand(0, $this->size),
			rand(1, ceil($this->size/40)),
			$this->main_color->get_close()
		);

	foreach($points as $i => $point1){
		imagefilledellipse(
			$this->canvas,
			$point1->x,
			$point1->y,
			$point1->z+1,
			$point1->z+1,
			$point1->color->get()
		);
		
		for($j=$i+1; $j<count($points); $j++){
			$point2 = $points[$j];

			$f = $point1;
			$s = $point2;
			if ($f->z > $s->z) {
				$temp = $f;
				$f = $s;
				$s = $temp;
			}
			$r1 = $f->z;
			$r2 = $s->z;
			$steps = $r2 - $r1 + 1;

			

			for ($k = 0; $k < $steps; $k++) {
				imagesetthickness($this->canvas, $k + $r1);
				imageline(
					$this->canvas,
					$f->x + ($s->x - $f->x) / $steps * $k, 
					$f->y + ($s->y - $f->y) / $steps * $k, 
					$f->x + ($s->x - $f->x) / $steps * ($k + 1), 
					$f->y + ($s->y - $f->y) / $steps * ($k + 1), 
					imagecolorexact(
						$this->canvas, 
						( $f->color->r() - ($f->color->r() - $s->color->r()) / $steps * $k), 
						( $f->color->g() - ($f->color->g() - $s->color->g()) / $steps * $k), 
						( $f->color->b() - ($f->color->b() - $s->color->b()) / $steps * $k)
					)
				);
			}
		}
	}

})();
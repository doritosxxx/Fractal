<?php
(function() use ($arguments){

	require_once("./classes/Point.php");

	function levy(Point $p1, Point $p2, $i, $pos, $angles, $_this){
		
		if ($i == 0) {
			if($p1->dist($p2) < 20 )
				imageline(	
					$_this->canvas,
					$p1->x, $p1->y,
					$p2->x, $p2->y, 
					$_this->main_color->get_close()->get()
				);
			return $pos;
		}

		if(!$pos[$i])
			$pos[$i]=0;

		$p3 = new Point(
			cos($angles[$pos[$i]])*( ($p2->x - $p1->x) * cos($angles[$pos[$i]])-($p2->y - $p1->y) * sin($angles[$pos[$i]])) + $p1->x,
			cos($angles[$pos[$i]])*( ($p2->x - $p1->x) * sin($angles[$pos[$i]])+($p2->y - $p1->y) * cos($angles[$pos[$i]])) + $p1->y
		);
		
		imagefilledellipse(
			$_this->canvas,
			$p3->x,
			$p3->y,
			6,
			6,
			$_this->main_color->get_close()->get()
		);
		$pos[$i]++;
		if ($pos[$i] == count($pos))
			$pos[$i] = 0;
		
		$i--;
		$pos = levy($p1, $p3, $i, $pos, $angles, $_this);
		$pos = levy($p3, $p2, $i, $pos, $angles, $_this);
		return $pos;

	};
	$angles = [];
	$depth = 0;

	if(isset($arguments['angles']))
		$angles = $arguments['angles'];
	else 
		for($i = 0; $i < 4; $i++)
			$angles[$i] = rand(-90, 90);

	if(isset($arguments['depth']))
		$depth = $arguments['depth'];
	else 
		$depth = mt_rand(10,16);
	
	
	$this->caption->add('angles: ' . implode(' ',array_map(function($angle){
		return $angle . '°';
	}, $angles)));

	$angles = array_map(function($angle){
		return $angle / 180 * M_PI;
	}, $angles);

	imagesetthickness($this->canvas, 6);
	levy(
		new Point(
			$this->size/2,
			$this->size/4
		),
		new Point(
			$this->size/2,
			$this->size/4*3
		),
		$depth, [], $angles, $this
	);
	
})();
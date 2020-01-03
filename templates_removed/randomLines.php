<?php


(function() use ($arguments){

	require_once("./classes/Point.php");
	imagesetthickness($this->canvas, 3);

	if(!isset($arguments['count']))
		$arguments['count'] = mt_rand(50,1500);
	$count = $arguments['count'];

	for($i=0; $i<$count; $i++){
		$p1 = $this->random_point();
		$p2 = $this->random_point();
		imageline(
			$this->canvas,
			$p1->x,
			$p1->y,
			$p2->x,
			$p2->y,
			$this->main_color->get_close()->get()
		);
	}

})();

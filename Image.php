<?php
class Caption{
    private $caption = [];
    public function add(string $value){
        $this->caption[] = $value;
    }
    public function __toString(){
        return implode(' ', $this->caption);
    }

}

class Color{
    private $components;
    private $alpha;
    private $canvas;
    private $color_gd;

    public function __construct($canvas, $r = null, $g = null, $b = null, int $alpha = 0){
        $this->canvas = $canvas;
        if($r === null || $g === null || $b === null)
            $this->components = [rand(0, 255), rand(0, 255), rand(0, 255)];
        else 
            $this->components = [$r, $g, $b];
        
        $this->alpha = $alpha;
        
        $this->refresh_gd();
    }

    public function r($r = null){
        if($r === null)
            return $this->components[0];
        $this->rgba($r, null, null, null);
    }
    public function g($g = null){
        if($g === null)
            return $this->components[1];
        $this->rgba(null, $g, null, null);
    }
    public function b($b = null){
        if($b === null)
            return $this->components[2];
        $this->rgba(null, null, $b, null);
    }
    public function alpha($alpha = null){
        if($alpha === null)
            return $this->alpha;
        $this->rgba(null, null, null, $alpha);
    }
    public function rgba($r = null, $g = null, $b = null, $alpha = null){
        if($r !== null)
            $this->components[0] = $r;
        if($g !== null)
            $this->components[1] = $g;
        if($b !== null)
            $this->components[2] = $b;
        if($alpha !== null)
            $this->alpha = $alpha;
        
        $this->refresh_gd();
    }

    private function refresh_gd(){
        $this->color_gd = imagecolorresolvealpha(
            $this->canvas,
            $this->components[0],
            $this->components[1],
            $this->components[2],
            $this->alpha
        );
    }

    public function get(){
        return $this->color_gd;
    }

    public function __toString(){
        return '#' . strtoupper(implode('', array_map( function($color){
            return str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
        } , $this->components)));
    }

    public function get_close($delta = 15){
        $new = array_map(function($color) use ($delta){
            $l = $color - $delta;
            $r = $color + $delta;
            if($delta >= 255){
                $l = 0;
                $r = 255;
            }
            else if($l < 0){
                $r -= $l;
                $l = 0;
            }
            else if($r > 255){
                $l -= $r - 255;
                $r = 255;
            }
            return rand($l, $r);
        }, $this->components);
        return new Color($this->canvas, $new[0], $new[1], $new[2], $this->alpha);
    }
}

class Image{
    public $size;
    public $canvas;
    public $caption;
    public $main_color;
    public function __construct(int $size = 2000){
        $this->size = $size;
        $this->canvas = imagecreatetruecolor($size, $size);
        imagesetthickness($this->canvas, 10);

        $this->caption = new Caption();
        $this->main_color = new Color($this->canvas); ///randomly genarated
        $this->caption->add("color: " . $this->main_color);
    }

    public function create(string $path = '') {
		if ($path !== '') {
			imagepng($this->canvas, $path);
		} else {
			header('Content-type: image/png');
			imagepng($this->canvas);
		}
		imagedestroy($this->canvas);
    }
    
    public function draw_template(string $name, array $arguments = []){
        $path = "./templates/$name" . (strpos($name, ".php") === false ? ".php" : "");

		if (!file_exists($path)) {
			echo "template not found";
			return;
		}
		include($path);
    }

    public function draw_random() {
		$templates = scandir("./templates/");
		unset($templates[0]);// .
		unset($templates[1]);// ..
		$selected = $templates[array_rand($templates)];
		$this->draw_template($selected);
    }
    
    public function random_x(){
        return rand(0, $this->size);
    }
    public function random_y(){
        return rand(0, $this->size);
    }
    public function random_point(){
        return new Point(
            $this->random_x(),
            $this->random_y()
        );
    }

}

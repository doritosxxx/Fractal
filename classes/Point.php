<?php

class Point{
    public $x, $y, $z;
    public $color;

    public function __construct( int $x = 0, int $y = 0, int $z = 0, Color $color = null){
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->color = $color;
    }
    public function dist( Point $other ){
        return sqrt( ($this->x - $other->x)**2 + ($this->y - $other->y)**2 + ($this->z - $other->z)**2);
    }
}


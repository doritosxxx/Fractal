<?php

class Function2Args{
    private $description, $f;

    public function __construct(Closure $f, string $description){
        $this->f = $f;
        $this->description = $description;
    }

    public function __toString(){
        return $this->description;
    }

    public function __invoke($a, $b){
        return ($this->f)($a, $b);
    }

}
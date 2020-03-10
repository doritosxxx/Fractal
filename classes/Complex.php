<?php

class Complex{

    public $real, $imaginary;

    static function isComplex($value){
        return is_object($value) && get_class($value) === "Complex";
    }

    static function toComplex($value){
        if(self::isComplex($value))
            return $value;
        return new Complex(floatval($value), 0);
    }

    static function e_pow_x(Complex $other){
        //e^ix = cosx + isinx
        return new Complex(
            cos($other->imaginary),
            sin($other->imaginary)
        );
    }
    
    public function __construct($real, $imaginary){
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    public function abs(){
        return sqrt($this->real ** 2 + $this->imaginary ** 2);
    }

    public function __toString(){
        return $this->real . ($this->imaginary > 0 ? '+' : '') . $this->imaginary . 'i';
    }

    public function multiply($other){
        $other = self::toComplex($other);
        return new Complex(
            $this->real * $other->real - $this->imaginary * $other->imaginary,
            $this->real * $other->imaginary + $this->imaginary * $other->real
        );
    }

    public function add($other){
        $other = self::toComplex($other);
        return new Complex(
            $this->real + $other->real, 
            $this->imaginary + $other->imaginary
        );
    }

    public function sub($other){
        $other = self::toComplex($other);
        return new Complex(
            $this->real - $other->real, 
            $this->imaginary - $other->imaginary
        );
    }

    
    
}

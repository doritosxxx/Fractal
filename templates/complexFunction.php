<?php
(function() use ($arguments){
    require_once("./classes/Complex.php");
    require_once("./classes/Function2Args.php");

    function draw(float $A, Function2Args $f, float $step = 1, Image $_this){
        $maxabs = -1;
        $values = [];

        for($B=0; $B<=$A; $B+=$step){
            $value = $f($A, $B);
            $values[] = $value;
            $maxabs = max($maxabs, $value->abs());
        };

        foreach($values as $complex){
            imagefilledellipse(
                $_this->canvas,
                intval($complex->real * $_this->size / $maxabs + $_this->size/2),
                intval($complex->imaginary * $_this->size / $maxabs + $_this->size/2),
                10,
                10,
                $_this->main_color->get_close()->get()
            );
        }
    }
    $A = rand(10, 1000) + rand(0,100)/100;
    
    // @return Complex
    $functions = [
        new Function2Args(
            function($a, $b){
                return Complex::e_pow_x(new Complex( 0, $b * cos($a) ))
                    ->multiply( $b * sin($b) );
            },
            "f(b)=b * sin(b) *  e^(i * b * cos($A))"
        ),
        new Function2Args(
            function($a, $b){
                return Complex::e_pow_x(new Complex( 0, $b * cos($a) ))
                    ->multiply( cos($b) * sin($b) * $b );
            },
            "f(b)=b * cos(b) * sin(b) * e^(i * b * cos($A))"
        ),
        new Function2Args(
            function($a, $b){
                return Complex::e_pow_x(new Complex( 0, $b * cos($a) ))
                    ->multiply( cos($b*($a+1)) );
            },
            "f(b)=cos(b * (" . ($A+1) . ")) * e^(i * b * cos($A))"
        ),
        new Function2Args(
            function($a, $b){
                return Complex::e_pow_x(new Complex( 0, $b * sin($a) ))
                    ->multiply( $b*sin($a+$b) );
            },
            "f(b)=b * sin(b+$A) * e^(i * b * sin($A))"
        ),
        new Function2Args(
            function($a, $b){
                return Complex::e_pow_x(new Complex( 0, $b * cos($a) ))
                    ->multiply( cos( $b * ($a + 1)  ) ** (3) );
            },
            "f(b)=cos( b*(" . ($A+1) . ") )^3 * e^(i * b * cos($A))"
        )
    ];

    $function = $functions[array_rand($functions)];
    $this->caption->add($function);
    
    draw($A, $function, .1, $this);


})();
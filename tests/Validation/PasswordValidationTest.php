<?php

class PasswordValidationTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $v = new Validation\PasswordValidation(array(
            'with_digits' => true,
            'max' => 10,
            'min' => 3,
        ));
        ok( $v );

        ok( $v->check('123nnn') );
    }
}


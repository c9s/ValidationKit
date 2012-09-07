<?php

class PasswordValidationTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $v = new ValidationKit\PasswordValidation(array(
            'with_digits' => true,
            'max' => 10,
            'min' => 3,
        ));
        ok( $v );

        ok( $v->validate('123nnn') );
    }
}


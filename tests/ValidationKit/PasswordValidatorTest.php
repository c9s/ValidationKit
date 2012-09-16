<?php

class PasswordValidatorTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $v = new ValidationKit\PasswordValidator(array(
            'with_digits' => true,
            'max_length' => 10,
            'min_length' => 3,
        ));
        ok( $v );
        ok( $v->validate('123nnn') );
        not_ok( $v->validate('11') );
        not_ok( $v->validate(md5(123)) );
    }
}


<?php

class StringLengthValidatorTest extends PHPUnit_Framework_TestCase
{
    function testStringLength()
    {
        $v = new ValidationKit\StringLengthValidator(array( 
            'min' => 5, 'max' => 10,
        ));
        ok($v);
        not_ok($v->validate(str_repeat('x',3)));
        ok($v->validate(str_repeat('x',10)));
        not_ok($v->validate(str_repeat('x',11)));
    }
}


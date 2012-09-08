<?php

class StringValidatorTest extends PHPUnit_Framework_TestCase
{
    function testStartWith()
    {
        $v = new ValidationKit\StringValidator(array( 
            'start_with' => 'foo_'
        ));
        ok($v);
        ok($v->validate('foo_ok'));
        not_ok($v->validate('bar_ok'));
    }

    function testEndWith()
    {
        $v = new ValidationKit\StringValidator(array( 
            'end_with' => '_suffix'
        ));
        ok($v);
        ok($v->validate('foo_suffix'));
        not_ok($v->validate('foo_bar'));
    }
}


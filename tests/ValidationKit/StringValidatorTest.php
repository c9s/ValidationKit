<?php

class StringValidatorTest extends PHPUnit_Framework_TestCase
{
    function testStartWith()
    {
        $v = new ValidationKit\StringValidator(array( 
            'starts_with' => 'foo_'
        ));
        ok($v);
        ok($v->validate('foo_ok'));
        not_ok($v->validate('bar_ok'));
    }

    function testEndWith()
    {
        $v = new ValidationKit\StringValidator(array( 
            'ends_with' => '_suffix'
        ));
        ok($v);
        ok($v->validate('foo_suffix'));
        not_ok($v->validate('foo_bar'));
    }

    function testIs()
    {
        $v = new ValidationKit\StringValidator('that');
        ok($v);
        ok($v->validate('that'));
        not_ok($v->validate('this'));
    }

    function testIs2()
    {
        $v = new ValidationKit\StringValidator(array( 'is' => 'that'));
        ok($v);
        ok($v->validate('that'));
        not_ok($v->validate('this'));
    }


    function testContains()
    {
        $v = new ValidationKit\StringValidator(array( 'contains' => 'position'));
        ok($v);
        ok($v->validate('Find the position of the first occurrence of a substring in a string'));
        not_ok($v->validate('Find the xxxx of the first occurrence of a substring in a string'));
    }

    function testExcept()
    {
        $v = new ValidationKit\StringValidator(array( 'except' => 'aaa'));
        ok($v);
        ok($v->validate('Find the position of the first occurrence of a substring in a string'));
        not_ok($v->validate('Find the aaa of the first occurrence of a substring in a string'));
    }

}


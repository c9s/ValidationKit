<?php
namespace ValidationKit;
use PHPUnit_Framework_TestCase;
use Exception;

class RangeValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Range testing
     */
    function test()
    {
        $v = new RangeValidator( array( '>' => 10 , '<' => 20 ) );
        not_ok($v->validate(10));
        ok( $v->validate(11) );
        ok( $v->validate(19) );
        ok( $v->validate(19.2) );
        not_ok( $v->validate('test') );
        not_ok( $v->validate('123') );
    }

    function test2()
    {
        $v = new RangeValidator( array( '>' => 10 , '<' => 20 , 'int' => true ) );
        ok( $v->validate(11) );
        ok( $v->validate(19) );
        ok( ! $v->validate(19.2) );
        ok( ! $v->validate("123") );
        ok( ! $v->validate('test') );
    }

    function test3()
    {
        $v = new RangeValidator( array( '>' => 100 , 'int' => true ) );
        ok( ! $v->validate("123") );
        ok( ! $v->validate('test') );
        ok( ! $v->validate(11) );
        ok( ! $v->validate(99) );
        ok( $v->validate(101) );
    }


}


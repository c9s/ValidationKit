<?php
namespace Validation;
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
        ok( $v->check(11) );
        ok( $v->check(19) );
        ok( $v->check(19.2) );
        ok( ! $v->check("123") );
        ok( ! $v->check('test') );
    }

    function test2()
    {
        $v = new RangeValidator( array( '>' => 10 , '<' => 20 , 'int' => true ) );
        ok( $v->check(11) );
        ok( $v->check(19) );
        ok( ! $v->check(19.2) );
        ok( ! $v->check("123") );
        ok( ! $v->check('test') );
    }

    function test3()
    {
        $v = new RangeValidator( array( '>' => 100 , 'int' => true ) );
        ok( ! $v->check("123") );
        ok( ! $v->check('test') );
        ok( ! $v->check(11) );
        ok( ! $v->check(99) );
        ok( $v->check(101) );
    }



}


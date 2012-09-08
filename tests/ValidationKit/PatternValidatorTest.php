<?php
namespace ValidationKit;
use PHPUnit_Framework_TestCase;
use Exception;

class PatternValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * test pattern
     */
    function test1()
    {
        $v = new PatternValidator( array('pattern' => '#[a-z]#') );
        ok( $v->validate( 'abc' ) );
        ok( ! $v->validate( '123' ) );
    }
}


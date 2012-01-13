<?php
namespace Validation;
use PHPUnit_Framework_TestCase;
use Exception;

class PatternValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * test pattern
     */
    function test1()
    {
        $v = new PatternValidator( '#[a-z]#' );
        ok( $v->check( 'abc' ) );
        ok( ! $v->check( '123' ) );
    }
}


<?php
namespace Validation;
use PHPUnit_Framework_TestCase;
use Exception;

class CallbackValidatorTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $validator = new CallbackValidator(function($value) {
            return true;
        });;
        ok( $validator->check(123) );
    }
}

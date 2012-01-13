<?php
namespace Validation;
use PHPUnit_Framework_TestCase;
use Exception;

class EmailValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * test email validator
     */
    function test()
    {
        $validator = new EmailValidator;
        ok( $validator->check( 'cornelius.howl@gmail.com' ) );
        ok( $validator->check( 'cornelius.howl@test.co.jp' ) );
        ok( $validator->check( 'cornelius.howl+github@test.co.jp' ) );
    }
}


<?php
namespace ValidationKit;
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
        ok( $validator->validate( 'cornelius.howl@gmail.com' ) );
        ok( $validator->validate( 'cornelius.howl@test.co.jp' ) );
        ok( $validator->validate( 'cornelius.howl+github@test.co.jp' ) );
    }
}


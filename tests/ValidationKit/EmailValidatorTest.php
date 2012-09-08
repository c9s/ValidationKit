<?php

class EmailValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * test email validator
     */
    function test()
    {
        $validator = new ValidationKit\EmailValidator;
        ok( $validator->validate( 'cornelius.howl@gmail.com' ) );
        ok( $validator->validate( 'cornelius.howl@test.co.jp' ) );
        ok( $validator->validate( 'cornelius.howl+github@test.co.jp' ) );
        not_ok( $validator->validate( 'cornelius.howl@test' ) );
        not_ok( $validator->validate( 'co.jp' ) );
    }
}


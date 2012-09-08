<?php

class TWPhoneNumberValidatorTest extends PHPUnit_Framework_TestCase
{
    function testAllowDash()
    {
        $validator = new ValidationKit\PhoneNumber\TWPhoneNumberValidator(array( 'allow_dash' => true ));
        ok($validator);
        ok($validator->validate('0975123123'));
        ok($validator->validate('0975-123123'));
        ok($validator->validate('06-237000344'));
        not_ok($validator->validate('06-'));
        ok($validator->validate('110'));
    }

    function testNonDash()
    {
        $validator = new ValidationKit\PhoneNumber\TWPhoneNumberValidator;
        ok($validator);
        ok($validator->validate('0975123123'));
        not_ok($validator->validate('06-237000344'));
        not_ok($validator->validate('0975-123123'));
        not_ok($validator->validate('06-'));
        ok($validator->validate('110'));
    }
}



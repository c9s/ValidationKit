<?php

class IDNumberValidatorTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $v = new ValidationKit\TW\IDNumberValidator;
        ok($v);
        ok($v->validate('A136411883'));
        ok($v->validate('A178161208'));
        ok($v->validate('A157354749'));
        ok($v->validate('I155729562'));
        not_ok($v->validate('BBBB'));
        not_ok($v->validate('B123456789'));
    }
}


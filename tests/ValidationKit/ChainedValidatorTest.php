<?php

class ChainedValidatorTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $validator = new ValidationKit\ChainedValidator(array( 
            'validators' => array( 
                array('ValidationKit\StringValidator',array('contains'=>'aaa'))
            )
        ));
        ok($validator);
        ok($validator->validate('xxx aaa bbb'));
    }
}


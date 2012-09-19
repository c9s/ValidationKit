--TEST--
Email Validator Test
--FILE--
<?php
$validator = new ValidationKit\EmailValidator;
$bool = $validator->validate('abc@google.com');
var_dump($bool);
--EXPECT--
bool(true)

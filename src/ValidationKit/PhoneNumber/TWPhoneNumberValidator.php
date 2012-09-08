<?php
namespace ValidationKit\PhoneNumber;
use ValidationKit\Validator;

class TWPhoneNumberValidator extends Validator
{
    public function validate($value) 
    {
        if( preg_match('/^\d{2,3}\d{6,}(?:#\d+)?$/', $value) )
            return $this->valid();
        if( preg_match('/^\d{3}$/', $value) )
            return $this->valid();
        if( preg_match('/^09\d{8}$/', $value) )
            return $this->valid();

        if( $this->getOption('allow_dash') ) {
            if( preg_match('/^09\d{2}-\d{6}$/', $value) )
                return $this->valid();
            if( preg_match('/^\d{2,3}-\d{6,}(?:#\d+)?$/', $value) )
                return $this->valid();
        }
        return $this->invalid();
    }
}



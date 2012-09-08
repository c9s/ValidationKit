<?php
namespace ValidationKit;

class EmailValidator extends Validator
{
    public function validate($value)
    {
        if( preg_match('#^([\w-_\.]+)(?:\+\w+)?\@([\w_-]+\.)+[a-zA-Z]{2,}$#', $value ) ) {
            return $this->valid();
        } else {
            return $this->invalid();
        }
    }
}

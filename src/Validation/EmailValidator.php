<?php
namespace Validation;

class EmailValidator extends Validator
{
    public function check($value)
    {
        $ret = preg_match('#^([\w-_\.]+)(?:\+\w+)?\@([\w_-]+\.)+[a-zA-Z]{2,}$#', $value );
        return $this->saveResult( $ret );
    }
}


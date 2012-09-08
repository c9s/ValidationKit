<?php
namespace ValidationKit;

class StringLengthValidator extends Validator
{
    public function validate($val) 
    {
        if($max = $this->getOption('max')) {
            if(strlen($val) > $max)
                return $this->invalid('max_error');
        }
        if($min = $this->getOption('min')) {
            if(strlen($val) < $min)
                return $this->invalid('min_error');
        }
        return $this->valid('valid');
    }
}



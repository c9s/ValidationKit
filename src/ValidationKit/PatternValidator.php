<?php
namespace ValidationKit;
use Exception;

class PatternValidator extends Validator 
{
    public $matches;

    public function validate($value) 
    {
        if( $this->saveResult( preg_match( $this->getOption('pattern') , $value , $matches ,$this->getOption('flags') ) ) ) {
            $this->matches = $matches;
            return true;
        }
        return false;
    }

    public function getMatches()
    {
        return $this->matches;
    }

}


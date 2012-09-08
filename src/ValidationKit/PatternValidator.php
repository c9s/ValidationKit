<?php
namespace ValidationKit;
use Exception;

class PatternValidator extends Validator 
{
    public $matches;

    public function validate($value) 
    {
        if( preg_match( $this->getOption('pattern'), 
                $value, 
                $matches,
                $this->getOption('flags') ) ) 
        {
            $this->matches = $matches;
            return $this->valid();
        }
        return $this->invalid();
    }

    public function getMatches()
    {
        return $this->matches;
    }

}


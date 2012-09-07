<?php
namespace ValidationKit;
use Exception;

class PatternValidator extends Validator 
{
    public $pattern;
    public $flags;
    public $matches;

    public function __construct($pattern, $flags = 0) {
        parent::__construct();
        $this->pattern = $pattern;
        $this->flags = $flags;
    }

    public function validate($value) 
    {
        if( $this->saveResult( preg_match( $this->pattern , $value , $matches ,$this->flags ) ) ) {
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


<?php
namespace Validation;
use Exception;

class RangeValidator
    extends Validator 
{

    public $greaterThan;
    public $lessThan;
    public $isInteger;

    public function  __construct( array $options ) 
    {
        parent::__construct();
        $this->greaterThan = @$options['greater_than'] ?: @$options['>'];
        $this->lessThan = @$options['less_than'] ?: @$options['<'];
        $this->isInteger = @$options['integer'] ?: @$options['int'] ?: false;
    }

    public function check($value)
    {
        if( is_numeric($value) ) {
            if( $this->isInteger && ! is_integer( $value ) ) {
                return $this->saveResult(false);
            }

            // check range
            $ret = 1;
            if ( $this->greaterThan !== null ) {
                $ret = $value > $this->greaterThan ;
            }
            if( $this->lessThan !== null ) {
                $ret = $ret && ($value < $this->lessThan);
            }
            if( $ret === 1 ) {
                throw new Exception("Nothing is compared.");
            }
            return $this->saveResult($ret);
        }
        return $this->saveResult(false);
    }
}


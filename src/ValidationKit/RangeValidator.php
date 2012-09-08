<?php
namespace ValidationKit;
use Exception;

class RangeValidator
    extends Validator 
{
    public function  __construct($options = array(),$messages = array()) 
    {
        if( isset($options['>']) )
            $options['greater_than'] = $options['>'];
        if( isset($options['<']) )
            $options['less_than'] = $options['<'];
        if( isset($options['int']) )
            $options['integer'] = $options['int'];
        parent::__construct($options,$messages);
    }

    public function validate($value)
    {
        if( ! is_numeric($value) )
            return $this->invalid('not_numeric');

        if( $this->getOption('integer') )  {
            if ( ! is_integer( $value ) || is_string($value) )
                return $this->invalid('integer_error');
        }
        if( $this->getOption('float') ) {
            if( ! is_float($value) ) 
                return $this->invalid('float_error');
        }

        if ( $greater = $this->getOption('greater_than') ) {
            if( $value <= $greater ) {
                return $this->invalid('greater_than_error');
            }
        }
        if( $less = $this->getOption('less_than') ) {
            if( $value >= $less ) {
                return $this->invalid('less_than_error');
            }
        }
        return $this->valid();
    }
}


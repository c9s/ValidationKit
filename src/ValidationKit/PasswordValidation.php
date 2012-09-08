<?php
namespace ValidationKit;

class PasswordValidation extends Validator
{
    public function validate($givenPassword)
    {
        if( $maxLength = $this->getOption('max_length') ) {
            if( strlen( $givenPassword ) > $maxLength ) {
                return $this->invalid('exceed_max_length');
            }
        }
        if( $minLength = $this->getOption('min_length') ) {
            if( strlen( $givenPassword ) < $minLength )  {
                return $this->invalid('require_min_length');
            }
        }

        if( $this->getOption('with_digits') ) {
            if( ! preg_match( '/\d/', $givenPassword ) ) 
                return $this->invalid('require_digits');
        }

        if( $this->getOption('with_alpha') ) {
            if( ! preg_match( '/[a-zA-Z]/' , $givenPassword ) ) 
                return $this->invalid('require_alpha');
        }
        return $this->valid();
    }
}





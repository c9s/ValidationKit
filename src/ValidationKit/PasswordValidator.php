<?php
namespace ValidationKit;

class PasswordValidator extends Validator
{
    public function validate($givenPassword)
    {
        if( $maxLength = $this->getOption('max_length') ) {
            if( strlen( $givenPassword ) > $maxLength ) {
                return $this->invalid('max_length_error');
            }
        }
        if( $minLength = $this->getOption('min_length') ) {
            if( strlen( $givenPassword ) < $minLength )  {
                return $this->invalid('min_length_error');
            }
        }

        if( $this->getOption('require_digits') ) {
            if( ! preg_match( '/\d/', $givenPassword ) ) 
                return $this->invalid('require_digits_error');
        }

        if( $this->getOption('require_alpha') ) {
            if( ! preg_match( '/[a-zA-Z]/' , $givenPassword ) ) 
                return $this->invalid('require_alpha_error');
        }
        return $this->valid();
    }
}





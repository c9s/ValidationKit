<?php
namespace Validation;

class PasswordValidation extends Validator
{

    protected $minLength;
    protected $maxLength;
    protected $withDigits;
    protected $withAlpha;

    const exceed_max_length = 3;
    const require_min_length = 4;
    const require_digits = 5;
    const require_alpha = 6;

    public function __construct($options = array() )
    {
        if( isset($options['with_digits']) )
            $this->withDigits = true;
        if( isset($options['with_alpha'] ) ) 
            $this->withAlpha = true;
        if( isset($options['min_length'] ) )
            $this->minLength = $options['min_length'];
        if( isset($options['max_length'] ) )
            $this->maxLength = $options['max_length'];
    }

    public function check($givenPassword)
    {
        if( $this->maxLength ) {
            if( strlen( $givenPassword ) > $this->maxLength ) {
                return $this->saveResult( false, self::exceed_max_length );
            }
        }
        if( $this->minLength ) {
            if( strlen( $givenPassword ) < $this->minLength )  {
                return $this->saveResult( false, self::require_min_length );
            }
        }

        if( $this->withDigits ) {
            if( ! preg_match( '/\d/', $givenPassword ) ) 
                return $this->saveResult( false, self::require_digits );
        }

        if( $this->withAlpha ) {
            if( ! preg_match( '/[a-zA-Z]/' , $givenPassword ) ) 
                return $this->saveResult( false, self::require_alpha );
        }

    }
}





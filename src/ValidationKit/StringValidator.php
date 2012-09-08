<?php
namespace ValidationKit;
use Exception;
use InvalidArgumentException;

class StringValidator extends Validator 
{
    /**
     * valid options:
     *    starts_with
     *    ends_with
     *    contains
     *    except
     *    ignore_case
     */
    public function __construct($options = array(), $messages = array())
    {
        if( empty($options) ) {
            throw new InvalidArgumentException('validate options is required.');
        }
        if( is_string($options) ) {
            $options = array( 'is' => $options );
        }
        $options = array_merge( array(
            'starts_with'  => null,
            'ends_with'    => null,
            'contains'    => null,
            'except'      => null,
            'is'          => null,
            'ignore_case' => false,
        ), $options );
        parent::__construct($options,$messages);
    }

    public function validate($value)
    {
        if( $is = $this->getOption('is') ) {
            if( $this->getOption('ignore_case') ) {
                if (strlen($is) !== strlen( $value ) 
                    || stripos($value,$is) !== 0 ) 
                    return $this->invalid('is_error');
            } else {
                if (strlen( $is ) !== strlen( $value ) 
                    || strpos($value,$is) !== 0 )
                    return $this->invalid('is_error');
            }
        }

        if( $startWith = $this->getOption('starts_with') ) {
            if( $this->getOption('ignore_case') ) {
                if( stripos( $value,$startWith ) !== 0 )
                    return $this->invalid('starts_with_error');
            } else {
                if( strpos( $value,$startWith ) !== 0 )
                    return $this->invalid('ends_with_error');
            }
        }

        if( $endWith = $this->getOption('ends_with') ) {
            $len = strlen($endWith);
            $pos = strlen($value) - $len;
            if( $this->getOption('ignore_case') ) {
                if( strripos($value, $endWith) !== $pos )
                    return $this->invalid('ends_with_error');
            } else {
                if( strrpos($value, $endWith) !== $pos )
                    return $this->invalid('ends_with_error');
            }
        }


        if( $contains = $this->getOption('contains') ) {
            if( $this->getOption('ignore_case') ) {
                if( strripos( $value, $contains ) === false )
                    return $this->invalid('contains_error');
            } else {
                if( strrpos( $value, $contains ) === false )
                    return $this->invalid('contains_error');
            }
        }

        if( $except = $this->getOption('except') ) {
            if( $this->getOption('ignore_case') ) {
                if( stripos($value, $except) !== false)
                    return $this->invalid('except_error');
            } else {
                if( strpos($value, $except) !== false)
                    return $this->invalid('except_error');
            }
        }
        return $this->valid();
    }
}



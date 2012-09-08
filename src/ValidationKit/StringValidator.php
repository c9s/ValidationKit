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
        $ret = 1;
        if( $is = $this->getOption('is') ) {
            if( isset($this->options['ignore_case']) ) {
                $ret = $ret && (strlen( $is ) === strlen( $value ) 
                        && stripos($value,$is) === 0 );
            } else {
                $ret = $ret && (strlen( $is ) === strlen( $value ) 
                        && strpos($value,$is) === 0 );
            }
        }

        if( $startWith = $this->getOption('starts_with') ) {
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && stripos( $value,$startWith ) === 0;
            } else {
                $ret = $ret && strpos( $value,$startWith ) === 0;
            }
        }

        if( $endWith = $this->getOption('ends_with') ) {
            $len = strlen( $endWith );
            $pos = strlen( $value ) - $len;
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && strripos($value, $endWith) === $pos;
            } else {
                $ret = $ret && strrpos($value, $endWith) === $pos;
            }
        }


        if( $contains = $this->getOption('contains') ) {
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && strripos( $value, $contains ) !== false;
            } else {
                $ret = $ret && strrpos( $value, $contains ) !== false;
            }
        }

        if( $except = $this->getOption('except') ) {
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && stripos($value, $except) === false;
            } else {
                $ret = $ret && strpos($value, $except) === false;
            }
        }

        if( $ret === 1 ) {
            throw new Exception("Nothing compared, empty option?");
        } else {
            return $this->saveResult( $ret );
        }
    }
}



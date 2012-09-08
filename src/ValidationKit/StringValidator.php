<?php
namespace ValidationKit;
use Exception;

class StringValidator extends Validator 
{
    /**
     * valid options:
     *    start_with
     *    endWith
     *    contains
     *    except
     *    ignore_case
     */
    public function __construct($options, $messages = null)
    {
        if( is_string($options) ) {
            $options = array( 'is' => $options );
        }
        $options = array_merge( array(
            'start_with'  => null,
            'end_with'    => null,
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

        if( $startWith = $this->getOption('start_with') ) {
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && stripos( $value,$startWith ) === 0;
            } else {
                $ret = $ret && strpos( $value,$startWith ) === 0;
            }
        }

        if( $endWith = $this->getOption('end_with') ) {
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

        if( $except = @$options['except'] ) {
            if( $this->getOption('ignore_case') ) {
                $ret = $ret && strripos($value, $except ) === false;
            } else {
                $ret = $ret && strrpos($value, $except ) === false;
            }
        }

        if( $ret === 1 ) {
            throw new Exception("Nothing compared, empty option?");
        } else {
            return $this->saveResult( $ret );
        }
    }
}



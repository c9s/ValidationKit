<?php
namespace ValidationKit;
use Exception;

class StringValidator extends Validator 
{
    public $options;
    public $ignoreCase;

    /**
     * valid options:
     *    start_with
     *    end_with
     *    contains
     *    except
     *    ignore_case
     */
    public function __construct($options) 
    {
        parent::__construct();
        if( is_string($options) ) {
            $options = array( 'is' => $options );
        }

        $this->options = array_merge( array(
            'start_with' => null,
            'end_with' => null,
            'contains' => null,
            'except' => null,
            'is' => null,
            'ignore_case' => false,
        ), $options );

        $this->ignoreCase = $this->options['ignore_case'];
    }

    public function check($value)
    {
        $ret = 1;

        if( $is = @$options['is'] ) {
            if( $this->ignoreCase ) {
                $ret = $ret && (strlen( $is ) === strlen( $value ) 
                        && stripos($is,$value) === 0 );
            } else {
                $ret = $ret && (strlen( $is ) === strlen( $value ) 
                        && strpos($is,$value) === 0 );
            }
        }

        if( $start_with = @$options['start_with'] ) {
            if( $this->ignoreCase ) {
                $ret = $ret && stripos( $start_with , $value ) === 0;
            } else {
                $ret = $ret && strpos( $start_with , $value ) === 0;
            }
        }

        if( $end_with = @$options['end_with'] ) {
            $len = strlen( $end_with );
            $pos = strlen( $value ) - $len;
            if( $this->ignoreCase ) {
                $ret = $ret && strripos( $end_with , $value ) === $pos;
            } else {
                $ret = $ret && strrpos( $end_with , $value ) === $pos;
            }
        }


        if( $contains = @$options['contains'] ) {
            if( $this->ignoreCase ) {
                $ret = $ret && strripos( $contains, $value ) !== false;
            } else {
                $ret = $ret && strrpos( $contains, $value ) !== false;
            }
        }

        if( $except = @$options['except'] ) {
            if( $this->ignoreCase ) {
                $ret = $ret && strripos( $except, $value ) === false;
            } else {
                $ret = $ret && strrpos( $except, $value ) === false;
            }
        }

        if( $ret === 1 ) {
            throw new Exception("Empty options");
        } else {
            return $this->saveResult( $ret );
        }
    }
}



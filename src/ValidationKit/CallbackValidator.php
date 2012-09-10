<?php
namespace ValidationKit;

use Exception;

class CallbackValidator 
    extends Validator
{
    public $callbackArgs;

    public function __construct($callbackArgs)
    {
        $this->callbackArgs = $callbackArgs;
    }

    public function validate($value)
    {
        $ret = call_user_func_array( $this->callbackArgs , array($value) );
        return $this->reportResult( $ret );
    }

}


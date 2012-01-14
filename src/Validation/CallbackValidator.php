<?php
namespace Validation;

use Exception;

class CallbackValidator 
    extends Validator
{
    public $callbackArgs;

    public function __construct($callbackArgs)
    {
        $this->callbackArgs = $callbackArgs;
    }

    public function check($value)
    {
        $ret = call_user_func_array( $this->callbackArgs , array($value) );
        return $this->saveResult( $ret );
    }

}


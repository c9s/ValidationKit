<?php
namespace Validation;

/**
 *
 * $validator = new PatternValidator( '#test test test#' );
 * $bool = $validator->check( $value );
 * $msg  = $validator->getMessage();
 *
 * $validator = new StringValidator(array( 
 *      'start_with' => '....' , 
 *      'end_with' => ... 
 *      ));
 * $bool = $validator->check( $string );
 * $msg  = $validator->getMessage();
 *
 * $validator = new IntegerRangeValidator(1, 100);
 * $bool = $validator->check( 200 );
 *
 * $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
 * $bool = $validator->check( 10.0 );
 */

abstract class Validator 
{
    const valid = 0;
    const invalid = 1;

    public $messages;


    /**
     * @var boolean
     */
    public $isValid;

    /**
     * message code
     */
    public $code;

    public function __construct()
    {
        // init default messages
        $this->messages = array(
            self::valid   => "Valid data",
            self::invalid => "Invalid data",
        );
    }

    abstract function check($value);

    protected function saveResult($result,$code = null)
    {
        if( $result ) {
            $this->setSuccess($code);
        } else {
            $this->setError($code);
        }
    }

    protected function setSuccess($code = null)
    {
        $this->code = $code ?: self::valid;
        return $this->isValid = true;
    }

    protected function setError($code = null)
    {
        $this->code = $code ?: self::invalid;
        return $this->isValid = false;
    }

    protected function isSuccess()
    {
        return $this->isValid === true;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage() 
    {
        return $this->messages[ $this->code ];
    }

    public function setInvalidMessage($msg)
    {
        $this->messages[ self::invalid ] = $msg;
    }

    public function setValidMessage($msg)
    {
        $this->messages[ self::valid ] = $msg;
    }

    public function setMessage($msg,$code)
    {
        $this->messages[ $code ] = $msg;
    }
}


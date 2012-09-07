<?php
namespace ValidationKit;
use Exception;

/**
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
     *
     * @var integer code number for message
     */
    public $code;

    public function __construct()
    {
        // register default messages
        $this->messages = array(
            self::valid   => "Valid data",
            self::invalid => "Invalid data",
        );
    }


    /**
     * @param mixed $value 
     */
    abstract function check($value);


    /**
     * 
     * @param boolean $result 
     * @param integer $code code of message
     *
     * @return boolean success or failed.
     */
    protected function saveResult($result,$code = null)
    {
        if( $result ) {
            return $this->setSuccess($code);
        } else {
            return $this->setError($code);
        }
    }


    /**
     * set flag to success (valid)
     *
     * @param integer $code
     */
    protected function setSuccess($code = null)
    {
        $this->code = $code ?: self::valid;
        return $this->isValid = true;
    }

    /**
     * set flag to invalid (valid)
     *
     * @param integer $code
     */
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


    /**
     * set code message
     *
     * @param string $msg 
     * @param integer $code code number
     */
    public function setMessage($msg,$code)
    {
        $this->messages[ $code ] = $msg;
    }

}


<?php
namespace ValidationKit;
use Exception;

/**
 * $validator = new PatternValidator( '#test test test#' );
 * $bool = $validator->validate( $value );
 * $msg  = $validator->getMessage();
 *
 * $validator = new StringValidator(array( 
 *      'start_with' => '....' , 
 *      'end_with' => ... 
 *      ));
 * $bool = $validator->validate( $string );
 * $msg  = $validator->getMessage();
 *
 * $validator = new IntegerRangeValidator(1, 100);
 * $bool = $validator->validate( 200 );
 *
 * $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
 * $bool = $validator->validate( 10.0 );
 */

abstract class Validator 
{
    const valid = 0;
    const invalid = 1;

    public $messages = array();

    public $options = array();


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


    /**
     * Initialize a validator with options and messages.
     *
     * @param array $options validate options.
     * @param array $messages customized messages.
     */
    public function __construct($options = array(), $messages = array())
    {
        $this->options = $options;

        if( ! $messages && isset($options['messages']) ) {
            $messages = $options['messages'];
        }
        $this->messages = $messages;
    }

    /**
     * @param mixed $value 
     */
    abstract function validate($value);


    /**
     * Save validate result (success or fail)
     * 
     * @param boolean $result success or fail
     * @param integer $code code of message
     *
     * @return boolean success or failed.
     */
    protected function saveResult($result,$code = null)
    {
        if( $result ) {
            return $this->setValid($code);
        } else {
            return $this->setInvalid($code);
        }
    }

    protected function invalid($code = null)
    {
        return $this->setInvalid($code);
    }

    protected function valid($code = null)
    {
        return $this->setValid($code);
    }


    /**
     * set flag to success (valid)
     *
     * @param integer $code
     */
    protected function setValid($code = null)
    {
        $this->code = $code ?: self::valid;
        return $this->isValid = true;
    }

    /**
     * set flag to invalid (valid)
     *
     * @param integer $code
     */
    protected function setInvalid($code = null)
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

    public function getOption($name) {
        if( isset($this->options[$name]) ) {
            return $this->options[$name];
        }
    }

    public function setOption($name) {
        if( isset($this->options[$name]) ) {
            return $this->options[$name];
        }
    }
}


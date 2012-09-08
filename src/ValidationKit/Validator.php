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
     * @var string message id for validation result.
     */
    public $resultMessageId;


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
        $this->messages = array_merge(array(
            'invalid' => 'Invalid data',
            'valid' => 'Invalid data',
        ),$messages);
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
    protected function saveResult($result,$msgId = null)
    {
        if( $result ) {
            return $this->valid($msgId);
        } else {
            return $this->invalid($msgId);
        }
    }

    protected function invalid($msgId = null)
    {
        $this->setResultMessageId($msgId);
        return $this->isValid = false;
    }

    protected function valid($msgId = null)
    {
        $this->setResultMessageId($msgId);
        return $this->isValid = true;
    }

    public function isInvalid()
    {
        return $this->isValid === true;
    }


    public function hasMessage($msgId)
    {
        return isset($this->messages[$msgId]);
    }

    /**
     * Get message with a message id
     *
     * @param string $msgId
     */
    public function getMessage($msgId) 
    {
        return $this->messages[$msgId];
    }


    public function setResultMessageId($msgId)
    {
        $this->resultMessageId = $msgId;
    }

    public function getResultMessage()
    {
        return $this->getMessage($this->resultMessageId);
    }

    /**
     * Set message
     *
     * @param string $msg 
     * @param integer $code code number
     */
    public function setMessage($msgId,$msg)
    {
        $this->messages[ $msgId ] = $msg;
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


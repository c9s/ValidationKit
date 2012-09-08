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
    /**
     * @var array result messages
     */
    public $messages = array();

    public $msgstrs = array();

    public $options = array();


    /**
     * @var boolean
     */
    public $isValid;


    /**
     * Initialize a validator with options and messages.
     *
     * @param array $options validate options.
     * @param array $msgstrs customized messages.
     */
    public function __construct($options = array(), $msgstrs = array())
    {
        $this->options = $options;

        if( ! $msgstrs && isset($options['messages']) ) {
            $msgstrs = $options['messages'];
        } elseif( ! $msgstrs ) {
            $msgstrs = array();
        }
        $this->msgstrs = array_merge(array(
            'invalid' => 'Invalid data',
            'valid' => 'Valid data',
        ),$msgstrs);
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

    protected function addMessage($msgId)
    {
        $this->messages[] = $this->getMsgstr($msgId);
    }


    protected function invalid($msgId = null)
    {
        $msgId = $msgId ?: 'invalid';
        $this->addMessage($msgId);
        $this->isValid = false;
        return false;
    }

    protected function valid($msgId = null)
    {
        $msgId = $msgId ?: 'valid';
        $this->addMessage($msgId);
        return $this->isValid = true;
    }

    public function isInvalid()
    {
        return $this->isValid === true;
    }



    /**
     * Check if a msgstr exists with msgId.
     *
     * @param string $msgId
     */
    public function hasMsgstr($msgId)
    {
        return isset($this->msgstrs[$msgId]);
    }


    /**
     * Get message string with a message id
     *
     * @param string $msgId
     */
    public function getMsgstr($msgId) 
    {
        if( isset($this->msgstrs[$msgId]) )
            return $this->msgstrs[$msgId];
    }


    /**
     * Set message
     *
     * @param string $msg 
     * @param integer $code code number
     */
    public function setMsgstr($msgId,$msg)
    {
        $this->msgstrs[ $msgId ] = $msg;
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


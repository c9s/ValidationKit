<?php
namespace ValidationKit;
use Exception;
use ValidationKit\ValidationMessage;

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
        $this->msgstrs = array_merge($this->getBuiltinMessages(),$this->getDefaultMessages());
        $this->msgstrs = array_merge($this->msgstrs, $msgstrs);
    }

    public function getBuiltinMessages()
    {
        return array(
            'invalid' => 'Invalid value',
            'valid' => 'Valid value',
        );
    }

    /**
     * This method is for subclass to override.
     */
    public function getDefaultMessages()
    {
        return array();
    }

    /**
     * @param mixed $value 
     */
    abstract function validate($value);


    /**
     * Save validate result (success or fail)
     * 
     * @param boolean $valid success or fail
     * @param string $msgId code of message
     *
     * @return boolean success or failed.
     */
    protected function reportResult($valid,$msgId = null)
    {
        if( $valid ) {
            return $this->valid($msgId);
        } else {
            return $this->invalid($msgId);
        }
    }

    public function addValidMessage($msgId)
    {
        $this->messages[ $msgId ] = ValidationMessage::createValid($msgId,$this->getMsgstr($msgId));
    }

    public function addInvalidMessage($msgId)
    {
        $this->messages[ $msgId ] = ValidationMessage::createInvalid($msgId,$this->getMsgstr($msgId));
    }


    /**
     * Returns result messages
     *
     * @return array result messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set result messages
     *
     * @param array $messages 
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * Return a valid message with message id, 
     * the message string parameter is optional (for default message)
     *
     * If the message is defined in message dictionary, 
     * it won't overwrite it. 
     *
     * @param string $msgId
     * @param string $msgStr
     */
    protected function valid($msgId = null,$msgStr = null)
    {
        $msgId = $msgId ?: 'valid';
        $this->addValidMessage($msgId);
        if( ! $this->hasMsgstr($msgId) )
            $this->setMsgstr($msgId,$msgStr);
        return $this->isValid = true;
    }

    protected function invalid($msgId = null, $msgStr = null)
    {
        $msgId = $msgId ?: 'invalid';
        $this->addInvalidMessage($msgId);
        if( ! $this->hasMsgstr($msgId) )
            $this->setMsgstr($msgId,$msgStr);
        $this->isValid = false;
        return false;
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


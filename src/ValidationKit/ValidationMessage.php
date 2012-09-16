<?php
namespace ValidationKit;

class ValidationMessage
{
    /**
     * @var boolean valid or invalid.
     */
    public $valid = true;

    /**
     * @var string validation message id (validation result type).
     */
    public $id; 

    /**
     * @var string validation message.
     */
    public $message;

    public static function createValid($msgId,$msg) {
        $msg = new self;
        $msg->id = $msgId;
        $msg->message = $msg;
        $msg->valid = true;
        return $msg;
    }

    public static function createInvalid($msgId,$msg) {
        $msg = new self;
        $msg->id = $msgId;
        $msg->message = $msg;
        $msg->valid = false;
        return $msg;
    }

    public function __toString() 
    {
        return $this->message;
    }
}


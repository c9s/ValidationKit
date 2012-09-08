<?php
namespace ValidationKit;

class ChainedValidator extends Validator
{
    public function __construct($options = array(), $messages = array()) {
        parent::__construct($options,$messages);

    }

    public function validate($value) {
        $validators = $this->getOption('validators');
        foreach( $validators as $validatorArgs ) {
            @list($class,$args,$messages) = $validatorArgs;
            $validator = new $class($args,$messages);
            $ret = $validator->validate($value);
            if($ret === false) {
                $this->isValid = false;
                $this->setMessages($validator->getMessages());
                return false;
            }
        }
        return $this->valid();
    }
}



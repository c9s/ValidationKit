
/*
  +------------------------------------------------------------------------+
  | Phalcon Framework                                                      |
  +------------------------------------------------------------------------+
  | Copyright (c) 2011-2012 Phalcon Team (http://www.phalconphp.com)       |
  +------------------------------------------------------------------------+
  | This source file is subject to the New BSD License that is bundled     |
  | with this package in the file docs/LICENSE.txt.                        |
  |                                                                        |
  | If you did not receive a copy of the license and are unable to         |
  | obtain it through the world-wide-web, please send an email             |
  | to license@phalconphp.com so we can send you a copy immediately.       |
  +------------------------------------------------------------------------+
  | Authors: Andres Gutierrez <andres@phalconphp.com>                      |
  |          Eduar Carvajal <eduar@phalconphp.com>                         |
  +------------------------------------------------------------------------+
*/

extern zend_class_entry *phalcon_validationkit_validator_ce;
extern zend_class_entry *phalcon_validationkit_validator_email_ce;
extern zend_class_entry *phalcon_validationkit_validator_string_length_ce;
extern zend_class_entry *phalcon_validationkit_validator_string_ce;

PHP_METHOD(Phalcon_ValidationKit_Validator, __construct);
PHP_METHOD(Phalcon_ValidationKit_Validator, saveResult);
PHP_METHOD(Phalcon_ValidationKit_Validator, addMessage);
PHP_METHOD(Phalcon_ValidationKit_Validator, getMessages);
PHP_METHOD(Phalcon_ValidationKit_Validator, setMessages);
PHP_METHOD(Phalcon_ValidationKit_Validator, invalid);
PHP_METHOD(Phalcon_ValidationKit_Validator, valid);
PHP_METHOD(Phalcon_ValidationKit_Validator, isInvalid);
PHP_METHOD(Phalcon_ValidationKit_Validator, hasMsgstr);
PHP_METHOD(Phalcon_ValidationKit_Validator, getMsgstr);
PHP_METHOD(Phalcon_ValidationKit_Validator, setMsgstr);
PHP_METHOD(Phalcon_ValidationKit_Validator, getOption);

PHP_METHOD(Phalcon_ValidationKit_EmailValidator, validate);

PHP_METHOD(Phalcon_ValidationKit_StringLengthValidator, validate);

PHP_METHOD(Phalcon_ValidationKit_StringValidator, __construct);
PHP_METHOD(Phalcon_ValidationKit_StringValidator, validate);

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator___construct, 0, 0, 1)
	ZEND_ARG_INFO(0, options)
	ZEND_ARG_INFO(0, msgstrs)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_validate, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_saveresult, 0, 0, 1)
	ZEND_ARG_INFO(0, result)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_addmessage, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_setmessages, 0, 0, 1)
	ZEND_ARG_INFO(0, messages)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_invalid, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_valid, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_hasmsgstr, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_getmsgstr, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_setmsgstr, 0, 0, 1)
	ZEND_ARG_INFO(0, msgId)
	ZEND_ARG_INFO(0, msg)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_validationkit_validator_getoption, 0, 0, 1)
	ZEND_ARG_INFO(0, name)
ZEND_END_ARG_INFO()


PHALCON_INIT_FUNCS(phalcon_validationkit_validator_method_entry){
	PHP_ME(Phalcon_ValidationKit_Validator, __construct, arginfo_phalcon_validationkit_validator___construct, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ABSTRACT_ME(Phalcon_ValidationKit_Validator, validate, arginfo_phalcon_validationkit_validator_validate)
	PHP_ME(Phalcon_ValidationKit_Validator, saveResult, arginfo_phalcon_validationkit_validator_saveresult, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, addMessage, arginfo_phalcon_validationkit_validator_addmessage, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, getMessages, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, setMessages, arginfo_phalcon_validationkit_validator_setmessages, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, invalid, arginfo_phalcon_validationkit_validator_invalid, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, valid, arginfo_phalcon_validationkit_validator_valid, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, isInvalid, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, hasMsgstr, arginfo_phalcon_validationkit_validator_hasmsgstr, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, getMsgstr, arginfo_phalcon_validationkit_validator_getmsgstr, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, setMsgstr, arginfo_phalcon_validationkit_validator_setmsgstr, ZEND_ACC_PUBLIC)
	PHP_ME(Phalcon_ValidationKit_Validator, getOption, arginfo_phalcon_validationkit_validator_getoption, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHALCON_INIT_FUNCS(phalcon_validationkit_validator_email_method_entry){
	PHP_ME(Phalcon_ValidationKit_EmailValidator, validate, arginfo_phalcon_validationkit_validator_validate, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHALCON_INIT_FUNCS(phalcon_validationkit_validator_string_length_method_entry){
	PHP_ME(Phalcon_ValidationKit_StringLengthValidator, validate, arginfo_phalcon_validationkit_validator_validate, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHALCON_INIT_FUNCS(phalcon_validationkit_validator_string_method_entry){
	PHP_ME(Phalcon_ValidationKit_StringValidator, __construct, arginfo_phalcon_validationkit_validator___construct, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(Phalcon_ValidationKit_StringValidator, validate, arginfo_phalcon_validationkit_validator_validate, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

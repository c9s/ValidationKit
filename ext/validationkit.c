
/*
  +------------------------------------------------------------------------+
  | ValidationKit                                                          |
  +------------------------------------------------------------------------+
  +------------------------------------------------------------------------+
  +------------------------------------------------------------------------+
  +------------------------------------------------------------------------+
*/

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_phalcon.h"
#include "validationkit.h"

#include "Zend/zend_operators.h"
#include "Zend/zend_exceptions.h"
#include "Zend/zend_interfaces.h"
#include "ext/spl/spl_exceptions.h"

#include "kernel/main.h"
#include "kernel/memory.h"

zend_class_entry *phalcon_validationkit_validator_ce;
zend_class_entry *phalcon_validationkit_validator_email_ce;
zend_class_entry *phalcon_validationkit_validator_string_length_ce;
zend_class_entry *phalcon_validationkit_validator_string_ce;

ZEND_DECLARE_MODULE_GLOBALS(validationkit)

PHP_MINIT_FUNCTION(validationkit){


	if(!zend_ce_serializable){
		fprintf(stderr, "Phalcon Error: Interface Serializable was not found");
		return FAILURE;
	}
	if(!zend_ce_iterator){
		fprintf(stderr, "Phalcon Error: Interface Iterator was not found");
		return FAILURE;
	}
	if(!spl_ce_SeekableIterator){
		fprintf(stderr, "Phalcon Error: Interface SeekableIterator was not found");
		return FAILURE;
	}
	if(!spl_ce_Countable){
		fprintf(stderr, "Phalcon Error: Interface Countable was not found");
		return FAILURE;
	}
	if(!zend_ce_arrayaccess){
		fprintf(stderr, "Phalcon Error: Interface ArrayAccess was not found");
		return FAILURE;
	}
        if(!spl_ce_InvalidArgumentException) {
		fprintf(stderr, "Phalcon Error: InvalidArgumentException was not found");
		return FAILURE;
        }

	/** Init globals */
	ZEND_INIT_MODULE_GLOBALS(validationkit, php_phalcon_init_globals, NULL);

	PHALCON_REGISTER_CLASS(ValidationKit, Validator, validationkit_validator, phalcon_validationkit_validator_method_entry, 0);
        zend_declare_property_null(phalcon_validationkit_validator_ce, SL("messages"), ZEND_ACC_PUBLIC TSRMLS_CC);
        zend_declare_property_null(phalcon_validationkit_validator_ce, SL("msgstrs"), ZEND_ACC_PUBLIC TSRMLS_CC);
	zend_declare_property_null(phalcon_validationkit_validator_ce, SL("options"), ZEND_ACC_PUBLIC TSRMLS_CC);
	zend_declare_property_bool(phalcon_validationkit_validator_ce, SL("isValid"), 0, ZEND_ACC_PUBLIC TSRMLS_CC);

	PHALCON_REGISTER_CLASS_EX(ValidationKit, EmailValidator, validationkit_validator_email, "validationkit\\validator", phalcon_validationkit_validator_email_method_entry, 0);

	PHALCON_REGISTER_CLASS_EX(ValidationKit, StringLengthValidator, validationkit_validator_string_length, "validationkit\\validator", phalcon_validationkit_validator_string_length_method_entry, 0);

	PHALCON_REGISTER_CLASS_EX(ValidationKit, StringValidator, validationkit_validator_string, "validationkit\\validator", phalcon_validationkit_validator_string_method_entry, 0);

	return SUCCESS;
}

PHP_MSHUTDOWN_FUNCTION(validationkit){
	if (PHALCON_GLOBAL(active_memory) != NULL) {
		phalcon_clean_shutdown_stack(TSRMLS_C);
	}
	return SUCCESS;
}

PHP_RINIT_FUNCTION(validationkit){
	return SUCCESS;
}

PHP_RSHUTDOWN_FUNCTION(validationkit){
	if (PHALCON_GLOBAL(active_memory) != NULL) {
		phalcon_clean_shutdown_stack(TSRMLS_C);
	}
	return SUCCESS;
}

zend_module_entry validationkit_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	PHP_PHALCON_EXTNAME,
	NULL,
	PHP_MINIT(validationkit),
	PHP_MSHUTDOWN(validationkit),
	PHP_RINIT(validationkit),
	PHP_RSHUTDOWN(validationkit),
	NULL,
#if ZEND_MODULE_API_NO >= 20010901
	PHP_PHALCON_VERSION,
#endif
	STANDARD_MODULE_PROPERTIES
};

#ifdef COMPILE_DL_VALIDATIONKIT
ZEND_GET_MODULE(validationkit)
#endif


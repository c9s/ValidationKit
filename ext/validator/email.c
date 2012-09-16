
/*
  +------------------------------------------------------------------------+
  |  Validation Kit Framework                                              |
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

#include "kernel/main.h"
#include "kernel/memory.h"

#include "kernel/exception.h"
#include "kernel/object.h"
#include "kernel/fcall.h"
#include "kernel/array.h"
#include "kernel/concat.h"
#include "kernel/operators.h"


PHP_METHOD(Phalcon_ValidationKit_EmailValidator, validate){

        zval *value = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &value) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_BOOL(0);
        }

        zval *regex = NULL, *regex_result = NULL;
        PHALCON_INIT_VAR(regex);
        PHALCON_INIT_VAR(regex_result);

        ZVAL_STRING(regex, "#^([\\w-_\\.]+)(?:\\+\\w+)?\\@([\\w_-]+\\.)+[a-zA-Z]{2,}$#", 1);

        PHALCON_CALL_FUNC_PARAMS_2(regex_result, "preg_match", regex, value);

        if (Z_LVAL_P(regex_result)) {
            PHALCON_CALL_METHOD(return_value, this_ptr, "valid", PH_NO_CHECK);
        }else {
            PHALCON_CALL_METHOD(return_value, this_ptr, "invalid", PH_NO_CHECK);
        }

        PHALCON_MM_RESTORE();
}


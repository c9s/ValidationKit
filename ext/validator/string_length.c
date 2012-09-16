
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

PHP_METHOD(Phalcon_ValidationKit_StringLengthValidator, validate){

        zval *value = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &value) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        zval *max = NULL, *min = NULL;
        zval *key1 = NULL, *key2 = NULL;
        zval *error = NULL;

        PHALCON_INIT_VAR(max);
        PHALCON_INIT_VAR(min);
        PHALCON_INIT_VAR(key1);
        PHALCON_INIT_VAR(key2);
        PHALCON_INIT_VAR(error);

        // process max
        ZVAL_STRING(key1, "max", 1);
        PHALCON_CALL_METHOD_PARAMS_1(max, this_ptr, "getOption", key1, PH_NO_CHECK);

        if (Z_TYPE_P(max) != IS_NULL) {
            if (Z_STRLEN_P(value) > Z_LVAL_P(max)) {
                ZVAL_STRING(error, "max_error", 1);
                PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                goto mm_restore_return;
            }

        }

        // process min
        ZVAL_STRING(key2, "min", 1);
        PHALCON_CALL_METHOD_PARAMS_1(min, this_ptr, "getOption", key2, PH_NO_CHECK);

        if (Z_TYPE_P(min) != IS_NULL) {
            if (Z_STRLEN_P(value) < Z_LVAL_P(min)) {
                ZVAL_STRING(error, "min_error", 1);
                PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                goto mm_restore_return;
            }

        }

        PHALCON_CALL_METHOD(return_value, this_ptr, "valid", PH_NO_CHECK);

        mm_restore_return:
        PHALCON_MM_RESTORE();
}


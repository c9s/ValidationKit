
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

PHP_METHOD(Phalcon_ValidationKit_TValidator, validate){

        zval *value = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &value) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_BOOL(0);
        }

        PHALCON_CALL_METHOD(return_value, this_ptr, "valid", PH_NO_CHECK);

        mm_restore_return:
        PHALCON_MM_RESTORE();
}


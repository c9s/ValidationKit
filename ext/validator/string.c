
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
#include "ext/spl/spl_exceptions.h"

#include "kernel/main.h"
#include "kernel/memory.h"

#include "kernel/exception.h"
#include "kernel/object.h"
#include "kernel/fcall.h"
#include "kernel/array.h"
#include "kernel/concat.h"
#include "kernel/operators.h"

PHP_METHOD(Phalcon_ValidationKit_StringValidator, __construct)
{

        zval *options = NULL, *messages = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|zz", &options, &messages) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        if (!options) {
            PHALCON_THROW_EXCEPTION_STR(spl_ce_InvalidArgumentException, "validate options is required.");
            goto mm_restore_return;
        }
        if (!messages) {
            PHALCON_INIT_VAR(messages);
            array_init(messages);
        }

        zval *new_options = NULL;
        PHALCON_INIT_VAR(new_options);
        array_init(new_options);

        if (Z_TYPE_P(options) == IS_STRING) {

            phalcon_array_update_string(&new_options, SL("is"), &options, PH_COPY TSRMLS_CC);

        }else if (Z_TYPE_P(options) == IS_ARRAY || Z_TYPE_P(options) == IS_OBJECT) {

            zval *count = NULL;
            PHALCON_INIT_VAR(count);
            phalcon_fast_count(count, options);

            if (Z_LVAL_P(count) == 0) {
                PHALCON_THROW_EXCEPTION_STR(spl_ce_InvalidArgumentException, "validate options is required.");
                goto mm_restore_return;
            }

            PHALCON_CPY_WRT(new_options, options);

        }else {
            goto mm_restore_return;
        }

        zval *def_options = NULL, *final_options = NULL;
        zval *null_value = NULL, *false_value = NULL;

        PHALCON_INIT_VAR(def_options);
        PHALCON_INIT_VAR(final_options);
        PHALCON_INIT_VAR(null_value);
        PHALCON_INIT_VAR(false_value);
        array_init(def_options);
        array_init(final_options);
        ZVAL_BOOL(false_value, 0);

        phalcon_array_update_string(&def_options, SL("starts_with"), &null_value, PH_COPY TSRMLS_CC);
        phalcon_array_update_string(&def_options, SL("end_with"), &null_value, PH_COPY TSRMLS_CC);
        phalcon_array_update_string(&def_options, SL("contains"), &null_value, PH_COPY TSRMLS_CC);
        phalcon_array_update_string(&def_options, SL("except"), &null_value, PH_COPY TSRMLS_CC);
        phalcon_array_update_string(&def_options, SL("is"), &null_value, PH_COPY TSRMLS_CC);
        phalcon_array_update_string(&def_options, SL("ignore_case"), &false_value, PH_COPY TSRMLS_CC);

        PHALCON_CALL_FUNC_PARAMS_2(final_options, "array_merge", def_options, new_options);

        PHALCON_CALL_PARENT_PARAMS_2_NORETURN(this_ptr, "ValidationKit\\StringValidator", "__construct", final_options, messages);


        mm_restore_return:
        PHALCON_MM_RESTORE();

}

PHP_METHOD(Phalcon_ValidationKit_StringValidator, validate){

        zval *value = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &value) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        zval *key = NULL, *option = NULL;
        zval *error = NULL;
        int ignore_case = 0;
        zval *ivalue = NULL, *ioption = NULL;
        zval *eval_return = NULL;

        // process ignore_case
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);

        ZVAL_STRING(key, "ignore_case", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {
            if (PHALCON_IS_TRUE(option)) ignore_case = 1;
        }

        // convert to lower
        if (ignore_case) {
            PHALCON_INIT_VAR(ivalue);
            PHALCON_CALL_FUNC_PARAMS_1(ivalue, "strtolower", value);
        }

        // process is
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);
        PHALCON_INIT_VAR(error);

        ZVAL_STRING(key, "is", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {
            if (ignore_case) {
                PHALCON_INIT_VAR(ioption);
                PHALCON_CALL_FUNC_PARAMS_1(ioption, "strtolower", option);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, ivalue, ioption TSRMLS_CC);

                if (Z_STRLEN_P(option) != Z_STRLEN_P(value) || (PHALCON_IS_FALSE(eval_return)) || Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "is_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }

            } else {
                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, value, option TSRMLS_CC);

                if (Z_STRLEN_P(option) != Z_STRLEN_P(value) || (PHALCON_IS_FALSE(eval_return)) || Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "is_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }
            }

        }

        // process starts_with
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);
        PHALCON_INIT_VAR(error);

        ZVAL_STRING(key, "starts_with", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {
            if (ignore_case) {
                PHALCON_INIT_VAR(ioption);
                PHALCON_CALL_FUNC_PARAMS_1(ioption, "strtolower", option);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, ivalue, ioption TSRMLS_CC);

                if ( (PHALCON_IS_FALSE(eval_return)) || Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "starts_with_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }

            } else {
                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, value, option TSRMLS_CC);

                if ( (PHALCON_IS_FALSE(eval_return)) || Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "starts_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }
            }

        }

        // process ends_with
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);
        PHALCON_INIT_VAR(error);

        ZVAL_STRING(key, "ends_with", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {

            int pos = Z_STRLEN_P(value) - Z_STRLEN_P(option);

            if (pos <0) {
                ZVAL_STRING(error, "starts_with_error", 1);
                PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                goto mm_restore_return;
            }

            if (ignore_case) {
                PHALCON_INIT_VAR(ioption);
                PHALCON_CALL_FUNC_PARAMS_1(ioption, "strtolower", option);

                zval *sub_value = NULL;
                PHALCON_INIT_VAR(sub_value);
                ZVAL_STRINGL(sub_value, (Z_STRVAL_P(ivalue)+pos), Z_STRLEN_P(option), 1);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, sub_value, ioption TSRMLS_CC);

                if (Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "ends_with_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }

            } else {

                zval *sub_value = NULL;
                PHALCON_INIT_VAR(sub_value);
                ZVAL_STRINGL(sub_value, (Z_STRVAL_P(value)+pos), Z_STRLEN_P(option), 1);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, sub_value, option TSRMLS_CC);

                if (Z_LVAL_P(eval_return) != 0) {
                    ZVAL_STRING(error, "ends_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }
            }

        }


        // process contains
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);
        PHALCON_INIT_VAR(error);

        ZVAL_STRING(key, "contains", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {

            if (ignore_case) {
                PHALCON_INIT_VAR(ioption);
                PHALCON_CALL_FUNC_PARAMS_1(ioption, "strtolower", option);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, ivalue, ioption TSRMLS_CC);

                if (PHALCON_IS_FALSE(eval_return)) {
                    ZVAL_STRING(error, "contains_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }

            } else {

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, value, option TSRMLS_CC);

                if (PHALCON_IS_FALSE(eval_return)) {
                    ZVAL_STRING(error, "contains_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }
            }

        }

        // process except
        PHALCON_INIT_VAR(option);
        PHALCON_INIT_VAR(key);
        PHALCON_INIT_VAR(error);

        ZVAL_STRING(key, "except", 1);
        PHALCON_CALL_METHOD_PARAMS_1(option, this_ptr, "getOption", key, PH_NO_CHECK);

        if (Z_TYPE_P(option) != IS_NULL) {

            if (ignore_case) {
                PHALCON_INIT_VAR(ioption);
                PHALCON_CALL_FUNC_PARAMS_1(ioption, "strtolower", option);

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, ivalue, ioption TSRMLS_CC);

                if (PHALCON_IS_NOT_FALSE(eval_return)) {
                    ZVAL_STRING(error, "except_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }

            } else {

                PHALCON_INIT_VAR(eval_return);
                phalcon_fast_strpos(eval_return, value, option TSRMLS_CC);

                if (PHALCON_IS_NOT_FALSE(eval_return)) {
                    ZVAL_STRING(error, "except_error", 1);
                    PHALCON_CALL_METHOD_PARAMS_1(return_value, this_ptr, "invalid", error, PH_NO_CHECK);
                    goto mm_restore_return;
                }
            }

        }

        PHALCON_CALL_METHOD(return_value, this_ptr, "valid", PH_NO_CHECK);

        mm_restore_return:
        PHALCON_MM_RESTORE();
}


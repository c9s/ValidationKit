
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

PHP_METHOD(Phalcon_ValidationKit_Validator, __construct){

        zval *options = NULL, *msgstrs = NULL, *messages = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|zz", &options, &msgstrs) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        if (!options) {
            PHALCON_INIT_VAR(options);
            array_init(options);
        }

        int msgstrs_exists = 0;
        msgstrs_exists = phalcon_array_isset_string(options, SS("msgstrs"));
        if (!msgstrs && msgstrs_exists) {
            PHALCON_INIT_VAR(msgstrs);
            phalcon_array_fetch_string(&msgstrs, options, SL("msgstrs"), PH_NOISY_CC);
        }else if (!msgstrs) {
            PHALCON_INIT_VAR(msgstrs);
            array_init(msgstrs);
        }

        zval *default_msgstrs = NULL;
        PHALCON_INIT_VAR(default_msgstrs);
        array_init(default_msgstrs);

        phalcon_array_update_string_string(&default_msgstrs, SL("invalid"), SL("Invalid Data"), 0 TSRMLS_CC);
        phalcon_array_update_string_string(&default_msgstrs, SL("valid"), SL("Valid Data"), 0 TSRMLS_CC);

        zval *final_msgstrs = NULL;
        PHALCON_INIT_VAR(final_msgstrs);

        PHALCON_CALL_FUNC_PARAMS_2(final_msgstrs, "array_merge", default_msgstrs, msgstrs);

        PHALCON_INIT_VAR(messages);
        array_init(messages);

        phalcon_update_property_zval(this_ptr, SL("options"), options TSRMLS_CC);
        phalcon_update_property_zval(this_ptr, SL("msgstrs"), final_msgstrs TSRMLS_CC);
        phalcon_update_property_zval(this_ptr, SL("messages"), messages TSRMLS_CC);

        PHALCON_MM_RESTORE();
}

PHP_METHOD(Phalcon_ValidationKit_Validator, saveResult){

        zval *result = NULL, *msgId = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z|z", &result, &msgId) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        if (!msgId) {
            PHALCON_INIT_VAR(msgId);
            ZVAL_NULL(msgId);
        }

        zval *ret = NULL;
        PHALCON_INIT_VAR(ret);

        if(PHALCON_IS_TRUE(result)) {
            PHALCON_CALL_METHOD_PARAMS_1(ret, this_ptr, "valid", msgId, PH_NO_CHECK);
        }else {
            PHALCON_CALL_METHOD_PARAMS_1(ret, this_ptr, "invalid", msgId, PH_NO_CHECK);
        }

        RETURN_CCTOR(ret);
}


PHP_METHOD(Phalcon_ValidationKit_Validator, addMessage){

        zval *result = NULL, *msgId = NULL;

        PHALCON_MM_GROW();

        if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &msgId) == FAILURE) {
            PHALCON_MM_RESTORE();
            RETURN_NULL();
        }

        zval *message = NULL;
        PHALCON_INIT_VAR(message);
        PHALCON_CALL_METHOD_PARAMS_1(message, this_ptr, "getMsgstr", msgId, PH_NO_CHECK);

        zval *messages = NULL;
        PHALCON_INIT_VAR(messages);
        phalcon_read_property(&messages, this_ptr, SL("messages"), PH_NOISY_CC);
        phalcon_array_append(&messages, message, 0 TSRMLS_CC);

        phalcon_update_property_zval(this_ptr, SL("messages"), messages TSRMLS_CC);

        PHALCON_MM_RESTORE();
}

PHP_METHOD(Phalcon_ValidationKit_Validator, getMessages){

    zval *messages = NULL;

    PHALCON_MM_GROW();

    PHALCON_INIT_VAR(messages);

    phalcon_read_property(&messages, this_ptr, SL("messages"), PH_NOISY_CC);

    RETURN_CCTOR(messages);

}

PHP_METHOD(Phalcon_ValidationKit_Validator, setMessages){

    zval *messages = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &messages) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    phalcon_update_property_zval(this_ptr, SL("messages"), messages TSRMLS_CC);

    PHALCON_MM_RESTORE();

    RETURN_CCTOR(this_ptr);
}

PHP_METHOD(Phalcon_ValidationKit_Validator, invalid)
{

    zval *msgId = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|z", &msgId ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    if (!msgId) {
        PHALCON_INIT_VAR(msgId);
        ZVAL_STRING(msgId, "invalid", 1);
    }

    PHALCON_CALL_METHOD_PARAMS_1_NORETURN(this_ptr, "addMessage", msgId, PH_NO_CHECK);

    phalcon_update_property_bool(this_ptr, SL("isValid"), 0 TSRMLS_CC);

    PHALCON_MM_RESTORE();

    RETURN_BOOL(0);

}

PHP_METHOD(Phalcon_ValidationKit_Validator, valid)
{

    zval *msgId = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|z", &msgId ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    if (!msgId) {
        PHALCON_INIT_VAR(msgId);
        ZVAL_STRING(msgId, "valid", 1);
    }

    PHALCON_CALL_METHOD_PARAMS_1_NORETURN(this_ptr, "addMessage", msgId, PH_NO_CHECK);

    phalcon_update_property_bool(this_ptr, SL("isValid"), 1 TSRMLS_CC);

    PHALCON_MM_RESTORE();

    RETURN_BOOL(1);

}

PHP_METHOD(Phalcon_ValidationKit_Validator, isInvalid)
{

    PHALCON_MM_GROW();

    zval *isValid = NULL;

    PHALCON_INIT_VAR(isValid);

    phalcon_read_property(&isValid, this_ptr, SL("isValid"), PH_NOISY_CC);

    RETURN_CTOR(isValid);
}

PHP_METHOD(Phalcon_ValidationKit_Validator, hasMsgstr)
{

    zval *msgId = NULL, *msgstrs = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &msgId ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_BOOL(0);
    }

    PHALCON_INIT_VAR(msgstrs);

    phalcon_read_property(&msgstrs, this_ptr, SL("msgstrs"), PH_NOISY_CC);

    int isset = phalcon_array_isset(msgstrs, msgId);

    PHALCON_MM_RESTORE();

    RETURN_BOOL(isset);

}

PHP_METHOD(Phalcon_ValidationKit_Validator, getMsgstr)
{

    zval *msgId = NULL, *msgstrs = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &msgId ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    PHALCON_INIT_VAR(msgstrs);

    phalcon_read_property(&msgstrs, this_ptr, SL("msgstrs"), PH_NOISY_CC);

    int isset = phalcon_array_isset(msgstrs, msgId);
    if (isset) {

        zval *msg = NULL;
        PHALCON_INIT_VAR(msg);

        phalcon_array_fetch(&msg, msgstrs, msgId, PH_NOISY_CC);

        RETURN_CCTOR(msg);

    }else {

        PHALCON_MM_RESTORE();
        RETURN_NULL();

    }

}

PHP_METHOD(Phalcon_ValidationKit_Validator, setMsgstr)
{

    zval *msgId = NULL, *msgstrs = NULL, *msg = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zz", &msgId, &msg ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    PHALCON_INIT_VAR(msgstrs);

    phalcon_read_property(&msgstrs, this_ptr, SL("msgstrs"), PH_NOISY_CC);
    phalcon_array_update_zval(&msgstrs, msgId, &msg, PH_COPY TSRMLS_CC);

    PHALCON_MM_RESTORE();

    RETURN_CCTOR(this_ptr);

}

PHP_METHOD(Phalcon_ValidationKit_Validator, getOption)
{

    zval *name = NULL, *options = NULL, *value = NULL;

    PHALCON_MM_GROW();

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &name ) == FAILURE) {
        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

    PHALCON_INIT_VAR(options);

    phalcon_read_property(&options, this_ptr, SL("options"), PH_NOISY_CC);

    int isset = phalcon_array_isset(options, name);
    if (isset) {

        PHALCON_INIT_VAR(value);

        phalcon_array_fetch(&value, options, name, PH_NOISY_CC);

        RETURN_CCTOR(value);

    }else {

        PHALCON_MM_RESTORE();
        RETURN_NULL();
    }

}


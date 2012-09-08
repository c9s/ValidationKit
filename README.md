# Validation


## Validators

- PhoneNumber/TWPhoneNumberValidator
- TW/IDNumberValidator.php
- CallbackValidator
- ChainedValidator
- EmailValidator
- PasswordValidation
- PatternValidator
- RangeValidator
- StringLengthValidator
- StringValidator

## PatternValidator 

    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->validate( $value );
    $msgs = $validator->getMessages();

## StringValidator

    $validator = new StringValidator(array( 
            'starts_with' => '....' , 
            'ends_with' => ... ,
            'is' => ...,
            'contains' => ...,
            'except' => ...,
        ));
    $bool = $validator->validate( $string );
    $msgs  = $validator->getMessages();

## RangeValidator

    $validator = new RangeValidator(array(
        'greater_than' => 100,
        'less_than' => 200,
    ));
    $bool = $validator->validate( 200 );

    $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
    $bool = $validator->validate( 10.0 );



# Validation


## Validators

- `ValidationKit\PhoneNumber\TWPhoneNumberValidator`
- `ValidationKit\TW\IDNumberValidator`
- `ValidationKit\CallbackValidator`
- `ValidationKit\ChainedValidator`
- `ValidationKit\EmailValidator`
- `ValidationKit\PasswordValidation`
- `ValidationKit\PatternValidator`
- `ValidationKit\RangeValidator`
- `ValidationKit\StringLengthValidator`
- `ValidationKit\StringValidator`

## Validator Constructor

ValidationKit Validator's constructor prototype is:

    __construct( $options = array() , $msgs = array() );

The $msgs() is an associative array that contains:

    msg_id => msg_str

For different kind of validation message, validator 
provides its custom msgid for message mapping, you
can simply override the message dictionary to customize 
your messages.

### PatternValidator 

```php
<?php
    use ValidationKit\PatternValidator;
    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->validate( $value );
    $msgs = $validator->getMessages();
```

### StringValidator

```php
<?php
    use ValidationKit\StringValidator;
    $validator = new StringValidator(array( 
            'starts_with' => '....' , 
            'ends_with' => ... ,
            'is' => ...,
            'contains' => ...,
            'except' => ...,
        ), array( 
            'invalid' => 'general invalid message',
            'starts_with_error' => 'error message'
        ));
    $bool = $validator->validate( $string );
    $msgs  = $validator->getMessages();
    foreach( $msgs as $msg ) {
        echo $msg, "\n";
    }
```

### RangeValidator

```php
<?php
    use ValidationKit\RangeValidator;
    $validator = new RangeValidator(array(
        'greater_than' => 100,
        'less_than' => 200,
    ));
    $bool = $validator->validate( 200 );

    $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
    $bool = $validator->validate( 10.0 );
```

# Hacking

Install dependencies:

    $ onion install

Run unit tests:

    $ phpunit


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

### EmailValidator

```php
<?php
use ValidationKit\EmailValidator;
$validator = new EmailValidator;
if( $validator->validate('foo@foo.com') ) {
    echo "Success!\n";
} else {
    foreach( $validator->getMessages() as $msgId => $msg ) {
        // $msg is a ValidationMessage object, 
        // which supports __toString() convertion.
        echo $msg . "\n";
    }
}
```


### PatternValidator 

```php
<?php
    use ValidationKit\PatternValidator;
    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->validate( $value );
    $msgs = $validator->getMessages();
```

### StringLengthValidator

```php
<?php
$validator = new ValidationKit\StringLengthValidator(array( 
    'min' => 5, 'max' => 10,
));
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
    foreach( $msgs as $msgId => $msg ) {
        echo $msg, "\n";
    }
```

### PasswordValidator

```php
<?php
$validator = new ValidationKit\PasswordValidator(array(
    'max_length' => 24,
    'min_length' => 10,
    'require_digits' => true,
    'require_alpha' => true,
), array( 
    'require_digits_error' => 'Please enter digits in your password',
    'require_alpha_error'  => 'Please enter alphabets in your password',
    'max_length_error' => 'The maximum length of password is 24 charactors.'
));
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


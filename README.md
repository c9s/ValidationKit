# Validation


Validators
----------

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

Validator Constructor
---------------------

ValidationKit Validator's constructor prototype is:

    __construct( $options = array() , $msgs = array() );

The $msgs() is an associative array that contains:

    msg_id => msg_str

For different kind of validation messages, every validator
provides its custom msgid for message mapping, you
can simply override the message dictionary to customize 
your messages.

The following sample code shows the format of message dictionary:

```php
$validtor = new PasswordValidator(array( /* options */ ), array( 
    'require_digits_error' => 'Please enter digits in your password',
    'require_alpha_error'  => 'Please enter alphabets in your password',
    'max_length_error' => 'The maximum length of password is 24 charactors.'
));
```

The following list is the default message mapping:

- valid
- invalid

And of course you can easily extend messages in your customized 
validator class.

To return an invalid message in your validator:

```php
return $this->invalid('require_digits_error');
```

To return an valid message in your validator:

```php
return $this->valid('require_digits_error');
```

To get the result messages from validator:

```php
$msgs = $validator->getMessages();
foreach( $msgs as $msgId => $msg ) {
    // $msg => ValidationMessage
}
```

The result message is a `ValidationMessage` object, there are three class
properties in `ValidationMessage`:

1. valid (boolean)
2. id (string, message id)
3. message (string, message)

### EmailValidator

```php
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
    use ValidationKit\PatternValidator;
    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->validate( $value );
    $msgs = $validator->getMessages();
```

### StringLengthValidator

```php
$validator = new ValidationKit\StringLengthValidator(array( 
    'min' => 5, 'max' => 10,
));
```

### StringValidator

```php
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
    use ValidationKit\RangeValidator;
    $validator = new RangeValidator(array(
        'greater_than' => 100,
        'less_than' => 200,
    ));
    $bool = $validator->validate( 200 );

    $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
    $bool = $validator->validate( 10.0 );
```

Customize your validator
------------------------

To write your own validator, here is the basic structure of a validator class:

```php
namespace YourApp;
use ValidationKit\Validator;

class YourValidator extends Validator
{
    public function validate($val) 
    {
        return $this->valid();
    }
}
```

You can provide your default message dictinory by defining a
`getDefaultMessages` method:

```php
namespace YourApp;
use ValidationKit\Validator;

class YourValidator extends Validator
{
    public function getDefaultMessages()
    {
        return array(
            'valid' => 'Its a valid value.',
            'too_large' => 'Your value is too large',
            'too_small' => 'Your value is too small',
        );
    }


    public function validate($val) 
    {
        if( $val > 30 )
            return $this->invalid('too_large');

        if( $val < 10 )
            return $this->invalid('too_small');
        return $this->valid();
    }
}
```

Hacking
--------

Install dependencies:

    $ composer install --dev

Run unit tests:

    $ phpunit


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

## PatternValidator 

```php
<?php
    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->validate( $value );
    $msgs = $validator->getMessages();
```

## StringValidator

```php
<?php
    $validator = new StringValidator(array( 
            'starts_with' => '....' , 
            'ends_with' => ... ,
            'is' => ...,
            'contains' => ...,
            'except' => ...,
        ));
    $bool = $validator->validate( $string );
    $msgs  = $validator->getMessages();
```

## RangeValidator

```php
<?php
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


# Validation

## PatternValidator 

    $validator = new PatternValidator( '#test test test#' );
    $bool = $validator->check( $value );
    $msg  = $validator->getMessage();

## StringValidator

    $validator = new StringValidator(array( 
            'start_with' => '....' , 
            'end_with' => ... ,
            'is' => ...,
            'contains' => ...,
            'except' => ...,
        ));
    $bool = $validator->check( $string );
    $msg  = $validator->getMessage();

## RangeValidator

    $validator = new RangeValidator(array(
        'greater_than' => 100,
        'less_than' => 200,
    ));
    $bool = $validator->check( 200 );

    $validator = new RangeValidator(array( '>' => 10 , '<' => 200 ));
    $bool = $validator->check( 10.0 );



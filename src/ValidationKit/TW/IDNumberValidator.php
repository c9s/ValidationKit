<?php
namespace ValidationKit\TW;
use ValidationKit\Validator;

class IDNumberValidator extends Validator
{

    public function calculateChecksum($str) 
    {
        $c = (int) $str[0] * 1;
        for($i = 1; $i < 11; $i++ )
            $c += $str[$i] * (10-$i);
        return 10 - ($c % 10);
    }

    public function validate($val) {
        if( strlen($val) !== 10 )
            return $this->invalid('length_error');
        if( ! preg_match('#^[a-zA-Z]\d{9}$#i',$val) )
            return $this->invalid('format_error');
        $a = stripos('ABCDEFGHJKLMNPQRSTUVWXYZIO',$val[0]) + 10;
        $c = $this->calculateChecksum($a . substr($val,1));
        if( $c == substr($val,-1) )
            return $this->valid();
        return $this->invalid();
    }
}


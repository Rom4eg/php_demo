<?php
namespace core\validator\fields;


class IntegerValidatorField extends NumericValidatorField{

    protected function validate($val){
        if(parent::validate($val)){
            return is_int($val);
        }
    }

    protected function _try_cast($value){
        $value = parent::_try_cast($value);
        return (int)$value;
    }
}


?>

<?php
namespace core\validator\fields;


class FloatValidatorField extends NumericValidatorField{

    protected function validate($val){
        if(parent::validate($val)){
            return is_float($val);
        }
    }

    protected function _try_cast($value){
        $value = parent::_try_cast($value);
        return (float)$value;
    }
}


?>

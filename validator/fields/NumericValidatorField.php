<?php
namespace core\validator\fields;
use Exception;

class NumericValidatorField extends AbstractValidatorField{

    protected $cast = true;

    public function __construct($value=null, $empty=false, $cast=true){
        $this->cast = $cast;
        parent::__construct($value, $empty);
    }

    public function clean(){
        $value = parent::clean();
        if(!$this->validate($value)){
            throw new Exception("Incorrect type. Expects numeric value, got ".gettype($this->value));
        }
        return $value;
    }

    protected function validate($val){
        if(is_numeric($val)){
            return true;
        }
        return  false;
    }

    public function __set($name, $value){
        $value = trim($value);
        if(!$this->validate($value)){
            if($this->cast){
                $value = $this->_try_cast($value);
            }
        }
        parent::__set($name, $value);
    }

    public function __get($name){
        $val = parent::__get($name);
        return trim($val);
    }

    protected function _try_cast($value){
        return $value * 1;

    }
}


?>

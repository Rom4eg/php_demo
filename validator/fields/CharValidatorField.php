<?php
namespace core\validator\fields;

use Exception;

class CharValidatorField extends AbstractValidatorField{

    protected $cast = true;

    public function __construct($value=null, $empty=false, $cast=true){
        $this->cast = $cast;
        parent::__construct(trim($value), $empty);
    }

    public function clean(){
        $value = parent::clean();
        if(is_string($value)){
            return $value;
        }
        if($this->cast){
            try{
                $value = $this->_try_cast($this->value);
                return $value;
            } catch(Exception $err){
                throw new Exception('Unable to cast '.$this->value.'('.gettype($this->value).') into string');
            }
        }
        throw new Exception("Incorrect type. Expects string, got ".gettype($this->value));
    }

    public function __set($name, $value){
        parent::__set($name, trim($value));
    }

    public function __get($name){
        $val = parent::__get($name);
        return trim($val);
    }

    private function _try_cast($value){
        return (string)$value;
    }
}


?>

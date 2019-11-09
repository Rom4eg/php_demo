<?php
namespace core\validator\fields;

use Exception;

class ArrayValidatorField extends AbstractValidatorField{

    protected $cast = true;

    public function __construct($value=null, $empty=false, $cast=true){
        $this->cast = $cast;
        parent::__construct((array)$value, $empty);
    }

    public function clean(){
        $value = parent::clean();
        if(is_array($value)){
            return $value;
        }
        if($this->cast){
            try{
                $value = $this->_try_cast($this->value);
                return $value;
            } catch(Exception $err){
                throw new Exception('Unable to cast '.$this->value.'('.gettype($this->value).') into array');
            }
        }
        throw new Exception("Incorrect type. Expects array, got ".gettype($this->value));
    }

    private function _try_cast($value){
        return (array)$value;
    }

    public function __set($name, $value){
        parent::__set($name, (array)$value);
    }
}


?>

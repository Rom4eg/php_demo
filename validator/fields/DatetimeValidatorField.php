<?php
namespace core\validator\fields;

use DateTime;
use Exception;

class DatetimeValidatorField extends AbstractValidatorField{

    protected $cast = true;

    public function __construct($value=null, $empty=false, $cast=true){
        $this->cast = $cast;
        parent::__construct($value, $empty);
    }

    public function clean(){
        $value = parent::clean();
        if($value instanceof DateTime){
            return $value;
        }
        if($this->cast){
            try{
                $value = $this->_try_cast($this->value);
                return $value;
            } catch(Exception $err){
                throw new Exception('Unable to cast '.$this->value.'('.gettype($this->value).') into DateTime');
            }
        }
        throw new Exception("Incorrect type. Expects DateTime object, got ".gettype($this->value));
    }

    private function _try_cast($value){
        return new DateTime($value);
    }
}


?>

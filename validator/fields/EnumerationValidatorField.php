<?php
namespace core\validator\fields;
use Exception;

class EnumerationValidatorField extends f\CharValidatorField{

    protected $enum = [];

    public function __construct($value=null, $enum=[], $empty=false, $cast=true){
        if(empty($enum)){
            throw new Exception("Enumeration can't be empty");
        }
        $this->enum = $enum;
        parent::__construct($value, $empty, $cast);
    }

    public function clean(){
        $value = parent::clean();
        if(in_array($value, $this->enum)){
            return true;
        }
        return false;
    }
}


?>

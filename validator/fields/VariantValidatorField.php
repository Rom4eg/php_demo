<?php
namespace core\validator\fields;

class VariantValidatorField extends AbstractValidatorField{

    protected $cast = true;
    protected $field = null;

    public function __construct($value=null, $empty=false, $cast=true){
        $this->cast = $cast;
        parent::__construct($value, $empty);
        $this->_set_field($value);
    }

    public function clean(){
        if($this->field){
            return $this->field->clean();
        }
        throw new Exception("VariantValidatorField undefined value type: ".gettype($this->value));
    }

    public function __set($name, $value){
        parent::__set($name, $value);
        if($name == 'value'){
            $this->_set_field($value);
        }
        $this->field->__set($name, $value);
    }

    public function __get($name){
        return $this->field->{$name};
    }

    private function _set_field($value){
        $item = new ArrayValidatorField();

        switch(gettype($value)){
            case 'array':
                $this->field = new ArrayValidatorField($value, $this->empty, $this->cast);
                break;
            case 'string':
                $this->field = new CharValidatorField($value, $this->empty, $this->cast);
                break;
            case 'integer':
                $this->field = new IntegerValidatorField($value, $this->empty, $this->cast);
                break;
            case 'double':
                $this->field = new FloatValidatorField($value, $this->empty, $this->cast);
                break;
        }
    }
}


?>

<?php
namespace core\validator\fields;
use \core\validator\interfaces as iface;

use ReflectionClass;
use Exception;

abstract class AbstractValidatorField implements iface\IValidatorField{

    protected $value = null;
    protected $empty = false;
    protected $used = false;

    public function __construct($value=null, $empty=false){
        $this->value = $value;
        $this->empty = $empty;
    }

    public function __get($name){
        $ref_class = new ReflectionClass($this);
        if($ref_class->hasProperty($name)){
            return $this->{$name};
        }
        throw new Exception("Property ".$name." doesn't exists.");
    }

    public function __set($name, $value){
        $ref_class = new ReflectionClass($this);
        if($ref_class->hasProperty($name)){
            $this->used = true;
            $this->{$name} = $value;
            return ;
        }
        throw new Exception("Unable to set property ".$name.": doesn't exists.");
    }

    public function clean(){
        if(!$this->empty && empty($this->value)){
            throw new Exception("Field is required.");
        }
        return $this->value;
    }
}

?>

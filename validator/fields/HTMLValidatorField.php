<?php
namespace core\validator\fields;


class HTMLValidatorField extends CharValidatorField{

    public function clean(){
        $val = parent::clean();
        return htmlentities($val);
    }

    public function __get($name){
        $val = parent::__get($name);
        return htmlentities($val);
    }
}

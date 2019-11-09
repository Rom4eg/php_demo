<?php
namespace core\sanitizer\elements;
use \core\sanitizer\interfaces as iface;


class NotNull implements iface\ISanitizerElement{

    protected $placeholder;

    public function __construct($placeholder){
        $this->placeholder = $placeholder;
    }

    public function sanitize($value){
        if(empty($value)){
            $value = $this->placeholder;
        }
        return $value;
    }
}

<?php
namespace core\sanitizer\elements;
use \core\sanitizer\interfaces as iface;

class IsArray implements iface\ISanitizerElement{

    public function sanitize($value){
        if(!is_array($value)){
            $value = [$value];
        }
        return $value;
    }
}

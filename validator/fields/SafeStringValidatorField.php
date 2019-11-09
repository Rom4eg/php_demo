<?php
namespace core\validator\fields;

class SafeStringValidatorField extends CharValidatorField{

    public function clean(){
        $value = parent::clean();
        $value = htmlspecialchars($value, ENT_QUOTES|ENT_HTML401, 'UTF-8');
        $value = ltrim($value, " \t="); // replace '=' symbol
        return $value;
    }

}


?>

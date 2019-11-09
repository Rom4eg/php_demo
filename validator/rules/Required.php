<?php
namespace core\validator\rules;
use \core\validator\ValidationException;
use \core\validator\interfaces as iface;


class Required implements iface\IValidationRule{

    public function validate($value): void{
        if(empty($value)){
            throw new ValidationError("Field is required");
        }
    }
}

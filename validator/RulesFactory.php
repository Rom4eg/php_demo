<?php
namespace core\validator;
use \core\validator\interfaces as iface;
use \core\validator\rules;

class RulesFactory {

    public static function create(string $type, array $args): iface\IValidationRule{
        switch($type){
                case rules\Required::class:
                    return new rules\Required();
                case rules\Contains::class:
                    return new rules\Contains(...$args);
            default:
                throw new \Exception("Undefined type");
        }
    }
}

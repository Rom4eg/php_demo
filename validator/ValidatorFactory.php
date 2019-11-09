<?php
namespace core\validator;
use \core\validator\interfaces as iface;
use \management\validators\ConsoleArguments;


class ValidatorFactory {

    public static function create(iface\IValidable $item): iface\IValidator{
        $validator = new Validator($item);
        $rules = new ValidatorList();
        $validator->setRules($rules);
        return $validator;
    }
}

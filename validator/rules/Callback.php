<?php
namespace core\validator\rules;
use \core\validator\interfaces as iface;

class Callback implements iface\IValidationRule{

    protected $func = null;

    public function __construct(callable $func){
        $this->func = $func;
    }

    public function validate($value): void{
        return ($this->func)($value);
    }
}

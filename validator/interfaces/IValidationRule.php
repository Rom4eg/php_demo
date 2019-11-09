<?php
namespace core\validator\interfaces;


interface IValidationRule{

    public function validate($value): void;
}

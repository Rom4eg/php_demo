<?php

/**
 * Validator
 */

declare(strict_types=1);

namespace core\validator;

use core\validator\interfaces\IValidable;
use core\validator\interfaces\IValidationRule;
use \core\validator\interfaces\IValidator;
use core\validator\interfaces\IValidatorList;

/**
 * Validate user input.
 * 
 * @package Core\Validator
 * @author Roman Paranichev <rparanichev@.ru>
 */
class Validator implements IValidator
{

    protected $callback_prefix = 'validate';

    protected $obj = null;

    protected $rules = null;

    protected $errors = null;

    /**
     * Constructor
     * 
     * @param IValidable $obj validated object 
     */
    public function __construct(IValidable $obj)
    {
        $this->obj = $obj;
        $this->errors = new \Ds\Map();
    }

    /**
     * Factory method
     * 
     * @param IValidable $obj object that needs to be validate
     * 
     * @return bool
     */
    public static function create(IValidable $obj): IValidator
    {
        $rules = new ValidatorList();
        $inst = new static($obj);
        $inst->setRules($rules);
        return $inst;
    }

    /**
     * Entry point. Start object validation
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        $this->obj->setValidators($this->rules);
        $this->extractCallbacks();
        foreach ($this->rules->getIterator() as $field => $rule_list) {
            $fld_val = $this->obj->getValidatedValue($field);
            foreach ($rule_list as $rule) {
                try {
                    $rule->validate($fld_val);
                } catch (\Exception $e) {
                    $this->addError($field, $e->getMessage());
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Extract all validator callback from validated object
     * 
     * Iterate over all properties and register validator callback 
     * as validated rule
     * 
     * Example:
     *  class MyContainer implements IValidable{
     *      public $my_prop;
     *      
     *      public function validate_my_prop($value): void
     *      {
     *          // do custom validation
     *          // when invalid - throw new ValidationError('invalid message')
     *      }
     *  }
     * 
     * @return void
     */
    protected function extractCallbacks(): void
    {
        $ref_class = new \ReflectionClass($this->obj);
        foreach ($ref_class->getProperties() as $prop) {
            $name = $prop->getName();
            $validator = $this->getCallbackName($name);
            if (method_exists($this->obj, $validator)) {
                $callback = $this->getCallback($validator);
                $this->rules->addRule($name, $callback);
            }
        }
    }

    /**
     * Wraps each validator callback with closure.
     * 
     * @param string $validator callback
     * 
     * @return IValidationRule
     */
    protected function getCallback(string $validator): IValidationRule
    {
        return new rules\Callback(
            (
                function ($val) use ($validator) {
                    return call_user_func_array([$this->obj, $validator], [$val]);
                }
            )->bindTo($this)
        );
    }

    /**
     * Formats property name as validator callback
     * 
     * @param string $name property name
     * 
     * @return string
     */
    public function getCallbackName(string $name): string
    {
        $prefix = $this->getCallbackPrefix();
        return implode('_', [$prefix, $name]);
    }

    /**
     * Add error
     * 
     * @param string $field invalid field
     * @param string $desc error text
     * 
     * @return void
     */
    protected function addError(string $field, string $desc): void
    {
        if (!$this->errors->hasKey($field)) {
            $this->errors->put($field, new \Ds\Vector());
        }
        $this->errors->get($field)->push($desc);
    }

    /**
     * Callback prefix getter
     * 
     * @return string
     */
    public function getCallbackPrefix(): string
    {
        return $this->callback_prefix;
    }

    /**
     * Rule list setter
     * 
     * @param IValidatorList $rules rules list
     * 
     * @return void
     */
    public function setRules(IValidatorList $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * Errors getter
     * 
     * @return \Ds\Map
     */
    public function getErrors(): \Ds\Map
    {
        return $this->errors;
    }

    /**
     * Validated object getter
     * 
     * @return IValidable
     */
    public function getObject(): IValidable
    {
        return $this->obj;
    }
}

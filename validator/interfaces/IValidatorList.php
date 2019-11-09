<?php
/**
 * Object can store validation rules
 */
namespace core\validator\interfaces;


/**
 * The Implementing object is validator rules container
 * 
 * @package Management\Notifications
 * @author Roman Paranichev <rparanichev@.ru>
 */
interface IValidatorList
{

    /**
     * Add new validation Rule
     * 
     * @param string $field field name
     * @param IValidationRule $rule rule for field
     * 
     * @return void
     */
    public function addRule(string $field, IValidationRule $rule): void;
}

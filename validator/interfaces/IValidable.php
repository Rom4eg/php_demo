<?php
/**
 * Indicates that an object can be validated
 */
namespace core\validator\interfaces;

/**
 * The Implementing object is verifiable
 * 
 * @package Management\Notifications
 * @author Roman Paranichev <rparanichev@.ru>
 */
interface IValidable
{

    /**
     * Add new validator rule
     * 
     * @param IValidatorList $list validator collection
     * 
     * @return void
     */
    public function setValidators(IValidatorList $list): void;

    /**
     * Field getter
     * 
     * @param string $name validator field getter
     * 
     * @return mixed
     */
    public function getValidatedValue(string $name);
}

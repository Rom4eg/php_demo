<?php
/**
 * List of values contains exact value
 */
declare(strict_types=1);
namespace core\validator\rules;

use \core\validator\ValidationError;
use \core\validator\interfaces\IValidationRule;

/**
 * Check exact value
 * 
 * @package Core\Validator
 * @author Roman Paranichev <rparanichev@.ru>
 */
class Contains implements IValidationRule
{
    protected $expected;

    /**
     * Constructor
     * 
     * @param mixed $expected expected value
     */
    public function __construct($expected)
    {
        $this->expected = $expected;
    }

    /**
     * Validation.
     * 
     * @param array $items_list checked array
     * 
     * @return void
     */
    public function validate($items_list): void
    {
        if (empty($this->expected)) {
            throw new ValidationError("Expected value can't be empty");
        }
        if (!in_array($this->expected, $items_list)) {
            $msg = sprintf("%s is required to be in list", $this->expected);
            throw new ValidationError($msg);
        }
    }
}
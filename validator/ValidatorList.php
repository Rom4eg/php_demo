<?php 
/**
 * List of Rules
 */
declare(strict_types=1);
namespace core\validator;

use \core\validator\interfaces as iface;
use \core\validator\rules;

/**
 * List of validation Rules
 * 
 * @package Core\Validator
 * @author Roman Paranichev <rparanichev@.ru>
 */
class ValidatorList implements iface\IValidatorList
{

    protected $rule_list = null;

    public function __construct(){
        $this->rule_list = new \Ds\Map();
    }

    public function addRule(string $field, iface\IValidationRule $rule): void{
        if(!$this->rule_list->hasKey($field)){
            $this->rule_list->put($field, new \Ds\Vector());
        }

        $this->rule_list->get($field)->push($rule);
    }

    public function required(string $name): void{
        $rule = RulesFactory::create(rules\Required::class, []);
        $this->addRule($name, $rule);
    }

    /**
     * Field contain expected value
     * 
     * @param string $name field name
     * @param mixed $expected expected value
     * 
     * @return void
     */
    public function contains(string $name, $expected): void
    {
        $rule = RulesFactory::create(rules\Contains::class, [$expected]);
        $this->addRule($name, $rule);
    }

    public function getIterator(): \Generator{
        foreach($this->rule_list as $key => $val){
            yield $key => $val;
        }
    }
}

<?php declare(strict_types=1);
namespace core\acl;
use \core\acl\interfaces as iface;


class AccessList implements iface\IAccessList{

    /**
     * List of access conditions
     * @var array
     */
    protected $rules = [];

    /**
     * {@inheritDoc}
     * @return array
     */
    public function getRules(): array{
        return $this->rules;
    }

    /**
     * Create 'equal' rule. key MUST be equal to value
     * Example:
     * $access_list->equal([$current_user->id => $invoice->owner->id]);
     * @param array $values
     */
    public function equal(array $values): void{
        $this->rules[] = RulesFactory::create(RulesFactory::EQUAL, $values);
    }

    /**
     * Create 'contains' rule. key MUST be contains in value array
     * Example:
     * $access_list->contains([$current_user->id => [$invoice->owner->id, $invoice->junior_manager->id]]);
     * @param array $values
     */
    public function contains(array $values): void{
        $this->rules[] = RulesFactory::create(RulesFactory::CONTAINS, $values);
    }
}

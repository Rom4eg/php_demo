<?php
namespace core\acl\interfaces;

interface IRulesFactory{

    /**
     * Factory. Create rules by type.
     * @param  string $type constant, rule type e.g. RulesFactory::EQUAL
     * @param  array  $values array of compared values
     * @return IRule
     */
    public static function create(string $type, array $values): IRule;
}

<?php declare(strict_types=1);
namespace core\acl;
use \core\acl\interfaces as iface;
use \core\acl\rules;

class RulesFactory{

    const EQUAL = 'equal';
    const CONTAINS = 'contains';

    /**
     * {@inheritDoc}
     * @param  string $type constant, rule type e.g. RulesFactory::EQUAL
     * @param  array  $values array of compared values
     * @return IRule
     */
    public static function create(string $type, array $values): iface\IRule{
        switch($type){
            case self::EQUAL:
                return new rules\Equal($values);
            case self::CONTAINS:
                return new rules\Contains($values);
            default:
                throw new \Exception("Undefined rule type");
        }
    }
}

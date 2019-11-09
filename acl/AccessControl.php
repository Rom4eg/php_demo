<?php declare(strict_types=1);
namespace core\acl;
use core\acl\interfaces as iface;

class AccessControl implements iface\IAccessControl{

    /**
     * Object that will be protected
     * @var iface\IProtectable
     */
    protected $item = null;

    /**
     * Access rules list
     * @var iface\IAccessList
     */
    protected $access_list = null;


    /**
     * {@inheritDoc}
     * @param iface\IProtectable $item object that uses acl
     */
    public function __construct(iface\IProtectable $item){
        $this->item = $item;
    }

    /**
     * {@inheritDoc}
     * @param  string $name
     * @param  array  $args
     * @return mixed
     */
    public function __call(string $name, array $args){
        assert(method_exists($this->item, $name));
        if($this->isAllowed()){
            return $this->item->{$name}($args);
        }
        return $this->item->accessDenied();
    }

    /**
     * {@inheritDoc}
     * @param iface\IAccessList $list
     */
    public function setAccessList(iface\IAccessList $list): void{
        $this->access_list = $list;
    }

    /**
     * {@inheritDoc}
     * @param  iface\IProtectable $item
     * @return self
     */
    public static function protect(iface\IProtectable $item): iface\IAccessControl{
        $inst = new static($item);
        $inst->setAccessList(new AccessList());
        return $inst;
    }

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function isAllowed(): bool{
        $this->item->setAccessRules($this->access_list);
        foreach($this->access_list->getRules() as $rule){
            if($rule->compare()){
                return True;
            }
        }
        return False;
    }

    /**
     * {@inheritDoc}
     * @return IProtectable
     */
    public function getObject(): iface\IProtectable{
        return $this->item;
    }
}

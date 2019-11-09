<?php
namespace core\acl\interfaces;

interface IAccessControl{

    /**
     * @param IProtectable $item object that uses acl
     */
    public function __construct(IProtectable $item);

    /**
     * Check privileges on each method
     * @param  string $name
     * @param  array  $args
     * @return mixed
     */
    public function __call(string $name, array $args);

    /**
     * Setup list of access rules
     * @param iface\IAccessList $list
     */
    public function setAccessList(IAccessList $list): void;

    /**
     * Factory method. Shortcut for object creation.
     * @param  iface\IProtectable $item
     * @return self
     */
    public static function protect(IProtectable $item): self;

    /**
     * Check object access
     * @return bool
     */
    public function isAllowed(): bool;

    /**
     * Return protectable object
     * @return IProtectable
     */
    public function getObject(): IProtectable;
}

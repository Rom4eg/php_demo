<?php
namespace core\acl\interfaces;


interface IProtectable{

    /**
     * Return access abilities
     * @return IAccessList
     */
    public function setAccessRules(IAccessList $list): void;

    /**
     * Executes when all tests are failed
     * @return mixed
     */
    public function accessDenied();
}

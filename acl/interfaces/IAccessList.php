<?php
namespace core\acl\interfaces;

interface IAccessList{

    /**
     * Get list of access rules
     * @return array
     */
    public function getRules(): array;
}

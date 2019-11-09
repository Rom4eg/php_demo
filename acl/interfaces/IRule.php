<?php
namespace core\acl\interfaces;


interface IRule{

    /**
     * Compare values
     * @return bool
     */
    public function compare(): bool;
}

<?php
namespace management\interfaces;

interface IActionContainer extends \Iterator, \Countable, \JsonSerializable, \ArrayAccess{

    /**
     * Checking for action exists
     * @param  string $name action name
     * @return bool
     */
    public function hasAction(string $name): bool;

    /**
     * Remove action
     * @param string $name action name
     */
    public function removeAction(string $name): void;

    /**
     * Get sigle task
     * @param  string $name name of the required task
     * @return IManagementAction
     */
    public function getAction(string $name): IAction;

    /**
     * Register a new management action
     * @param string $class task objects
     */
    public function addAction(IAction $class): void;
}

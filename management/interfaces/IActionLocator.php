<?php
/**
 * Action locator interface
 * php version 7.3.11
 */
namespace management\interfaces;


/**
 * Action locator interface
 * 
 * @category Management
 * @package Management\interface
 * @author Roman Paranichev <rparanichev@.ru>
 */
interface IActionLocator
{

    /**
     * Singletone constructor
     * 
     * @return IActionLocator
     */
    public static function getInstance(): IActionLocator;

    /**
     * Get action container
     * 
     * @return ifaceIActionContainer all action container
     */
    public function getActions(): IActionContainer;

    /**
     * Add new action
     * 
     * @param IManagementAction $act action
     * 
     * @return void
     */
    public static function addAction(IAction $act): void;
}

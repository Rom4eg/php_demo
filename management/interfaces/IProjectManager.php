<?php
namespace management\interfaces;

interface IProjectManager{
    /**
     * Execute command
     */
    public function runCommand(): void;

    /**
     * Locator setter
     * @param IActionLocator $locator
     */
    public function setLocator(IActionLocator $locator): void;

    /**
     * Locator getter
     * @return IActionLocator $locator
     */
    public function getLocator(): IActionLocator;

    /**
     * Create new arguments container
     * @return IArguments
     */
    public function createArgsContainer(): IArguments;

    /**
     * Get arguments
     * @return IArguments
     */
    public function getArgsCont(): IArguments;

    /**
     * Fire when action doesn't exists
     */
    public function doesntExists(): void;
}

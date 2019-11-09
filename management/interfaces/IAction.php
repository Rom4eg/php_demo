<?php
namespace management\interfaces;

interface IAction{

    /**
     * Return action name
     * @return string
     */
    public function getName(): string;

    /**
     * Return action description.
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get command arguments
     * @return array command args
     */
    public function getArgs(): array;

    /**
     * Fire when required action doesn't exists
     */
    public function doesntExist(): void;

    /**
     * Get available actions
     * @return IActionContainer actions
     */
    public function getActions(): IActionContainer;

    /**
     * Entry point.
     * @param IArguments $args
     */
    public function run(IArguments $args): void;

    /**
     * Indicies this action is final.
     * @return bool
     */
    public function isFinal(): bool;
}

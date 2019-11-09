<?php
namespace management\migration;
use \management\actions;
use \management\ActionLocator;
use \management\interfaces as iface;

class Help extends actions\Help{

    protected function getTitle(): string{
        return "Database migration tool";
    }

    public function getActions(): iface\IActionContainer{
        return ActionLocator::getInstance()->getActions()->getAction('migration')->getActions();
    }
}

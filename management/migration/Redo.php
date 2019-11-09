<?php
namespace management\migration;
use \core\models;
use \management\ActionLocator;
use \management\interfaces as iface;
use \management\Arguments;

class Redo extends MigrationAction{

    const name = 'redo';
    const desc = 'is a shortcut for doing a rollback and then migrating again';

    public function run(iface\IArguments $args): void{
        $res = models\MigrationModel::_last(1);
        $target = $res->first()->name;

        $rollback_arg = Arguments::create(['rollback', $target]);
        $rollback = ActionLocator::getInstance()->getActions()->getAction('migration')->getActions()->getAction('rollback');
        $rollback->run($rollback_arg);

        $migrate_arg = Arguments::create(['migrate']);
        $migrate = ActionLocator::getInstance()->getActions()->getAction('migration')->getActions()->getAction('migrate');
        $migrate->run($migrate_arg);
    }



    protected function printStatus(string $status): void{
        echo $status;
    }
}

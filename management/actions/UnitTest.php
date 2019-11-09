<?php declare(strict_types=1);
namespace management\actions;
use \PHPUnit\TextUI\Command;
use \management as manage;
use \management\interfaces as iface;

class UnitTest extends manage\ConsoleAction{
    const name = 'test';
    const desc = 'Run unittest';

    public function run(iface\IArguments $vector): void{
        $cmd = new Command();
        $cmd->run($vector->toArray(), true);
    }
}

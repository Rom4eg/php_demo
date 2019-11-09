<?php declare(strict_types=1);
namespace management\actions;
use \management as manage;
use \management\currency as curr;
use \management\interfaces as iface;
use \management\Arguments;

final class CurrencyTool extends manage\ConsoleAction{
    const name = 'currency';
    const desc = 'Currency tool.';

    public function run(iface\IArguments $args): void{
        $this->actions->addAction(curr\Help::factory());
        $this->actions->addAction(curr\FetchLatestCurrency::factory());
        $this->actions->addAction(curr\UpdateCurrencyInterval::factory());

        parent::run($args);
    }
}

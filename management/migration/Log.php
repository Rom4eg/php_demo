<?php
namespace management\migration;
use \core\models;
use \management\interfaces as iface;


class Log extends MigrationAction{

    const name = 'log';
    const desc = 'list applied migrations';

    public function run(iface\IArguments $args): void{
        $items = models\MigrationModel::_filter('1 order by create_date desc limit 10' , []);
        $txt = [];
        foreach($items as $item){
            $txt[] = "\n\e[33mMigration: ".$item->name."\e[0m";
            $txt[] = "\nAuthor: ".$item->create_user;
            $txt[] = "\nDate: ".$item->create_date;
        }
        $this->printLogs($txt);
    }

    public function printLogs(array $log_list): void{
        echo PHP_EOL;
        foreach($log_list as $log_item){
            echo $log_item;
        }
        echo PHP_EOL;
    }
}

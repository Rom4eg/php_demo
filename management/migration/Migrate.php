<?php
namespace management\migration;
use \management as manage;
use \management\ActionLocator;
use \core\models;
use \management\interfaces as iface;

class Migrate extends MigrationAction{

    const name = 'migrate';
    const desc = 'execute unapplied migrations.';

    public function run(iface\IArguments $args): void{
        $act = ActionLocator::getInstance()->getActions()->getAction('migration')->getActions()->getAction('list');
        $items = $act->getList();
        $list = [];
        if(!count($items)){
            $list[] = "\n\e[33mThere are no unapplied migrations.\e[0m\n";
            $this->printList($list);
        } else {
            $list[] = "\n\e[33mFollowing migrations will be executed:\e[0m\n";
            foreach($items as $item){
                $list[] = "\t ".$item."\n";
            }
            $this->printList($list);
            $answer = readline("\nContinue [y/N]: ");
            if($answer != 'y'){
                return ;
            }
        }
        $this->_migrate($items);
    }

    protected function _migrate($items){
        foreach($items as $item){
            $list = [];
            $list[] = "\n\e[33mMigrating ".$item." .... \e[0m";
            require_once implode(DIRECTORY_SEPARATOR, [$this->getMigrationLocation(), $item.'.php']);
            $migr_name = 'Migration_'.$item;
            $migration = new $migr_name();
            try{
                $migration->run();
                $completed = new models\MigrationModel();
                $completed->name = $item;
                $completed->create_date = date("Y-m-d H:i:s");
                $completed->create_user = 'root';
                $completed->save();
                $list[] = "\t\e[0m[\e[32mOK\e[0m]\n";
            } catch(\Exception $e){
                $list[] = "\t\e[0m[\e[31mFail\e[0m]\n\e[31m".$e->getMessage()."\e[0m\n";
                break;
            }
        }
        $this->printList($list);
    }

    protected function printList(array $list): void{
        foreach($list as $item){
            echo $item;
        }
    }
}

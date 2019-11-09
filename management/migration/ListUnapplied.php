<?php
namespace management\migration;
use \core\models;
use \management\interfaces as iface;

class ListUnapplied extends MigrationAction{

    const name = 'list';
    const desc = 'list unapplied migrations';

    public function run(iface\IArguments $args): void{
        $items = $this->getList();
        $list = [];
        if(!count($items)){
            $list[] = "\n\e[32mAll migrations are applied.\e[0m \n";
        } else {
            $list[] = "\nUnapplied migrations: \e[31m\n\n";
            foreach($items as $item){
                $list[] = sprintf("\t%s\n", $item);
            }
            $list[] = "\e[0m \n";
        }
        $this->printList($list);
    }

    public function getList(): array{
        $names = $this->getMigrationFiles();

        if(empty($names)){
            return [];
        }

        $complited = $this->getComplitedMigrations($names);
        $diff = array_diff($names, $complited);
        return array_filter($diff);
    }

    protected function getMigrationFiles(){
        $names = [];
        foreach(scandir($this->getMigrationLocation()) as $file){
            $path = implode(DIRECTORY_SEPARATOR, [$this->getMigrationLocation(), $file]);
            if(is_file($path)){
                $stats = pathinfo($path);
                $names[] = $stats['filename'];
            }
        }
        return $names;
    }

    protected function getComplitedMigrations(array $names): array{
        $marks = implode(',', array_fill(0, count($names), '?'));
        $complited = models\MigrationModel::_filter("name in (".$marks.") order by name", $names);
        $items = [];
        foreach($complited as $model){
            $items[] = $model->name;
        }
        return $items;
    }

    public function printList(array $list): void{
        foreach($list as $item){
            echo $item;
        }
    }
}

<?php
namespace management\migration;
use \core\models;
use \management\interfaces as iface;


class Fake extends MigrationAction{
    const name = 'fake';
    const desc = 'mark migration as already applied';
    protected $args = ['name'];

    public function run(iface\IArguments $args): void{
        $args = new \Ds\Vector($args->getArguments());
        if(empty($args->first())){
            $this->printStatus("\t\e[0m[\e[31mMigration name is required\e[0m");
            return ;
        }

        $name = $args->shift();
        $path = implode(DIRECTORY_SEPARATOR, [$this->getMigrationLocation(), $name.'.php']);

        if(!is_readable($path)){
            $this->printStatus("\e[0m\e[31mMigration ".$name." not found.\e[0m");
            return ;
        }

        if($this->alreadyApplied($name)){
            $this->printStatus("\t\e[0m\e[31mMigration already applied\e[0m");
            return ;
        }



        if($this->confirmAction($name)){
            $this->_fake($name);
        }
    }

    private function _fake(string $name): void{
        $migration = new models\MigrationModel();
        $migration->name = $name;
        $migration->create_date = date("Y-m-d H:i:s");
        $migration->create_user = 'root';
        $migration->save();
    }

    protected function confirmAction(string $name): bool{
        $this->printStatus("\n\e[33mMark ".$name." as already applied.\e[0m");
        $answer = readline("Continue [y/N]: ");
        return mb_strtolower($answer) == 'y';
    }

    protected function alreadyApplied(string $name): bool{
        $model = models\MigrationModel::_filter('name = :name', ['name' => $name]);
        return !!count($model);
    }

    protected function printStatus(string $status): void{
        echo $status.PHP_EOL;
    }
}

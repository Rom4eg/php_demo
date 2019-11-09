<?php
namespace management\migration;
use \core\models;
use \management\interfaces as iface;

class Rollback extends MigrationAction{

    const name = 'rollback';
    const desc = 'rolling back all migrations to the target migration, when name is not defined rolling back the latest migration';
    protected $args = ['name'];

    public function run(iface\IArguments $args): void{
        $args = new \Ds\Vector($args->getArguments());
        $target = '';
        if(!empty($args->first())){
            $target = $args->shift();
        }

        try{
            $this->_prepareRollback($target);
        } catch(\Exception $e){
            $this->printStatus("\e[31m\t\e[0m[\e[31mFail\e[0m]\n".$e->getMessage()."\n", False);
            return ;
        }

        $latest_migration = models\MigrationModel::_last(1);
        $this->printStatus("\n\e[33mCurrent migration is: ".$latest_migration->first()->name."\e[0m\n");
    }

    private function _prepareRollback(string $target): void{
        $res = $this->_getMigrationsStack($target);

        if(!count($res)){
            throw new \Exception("\e[31mMigration ".$target." not found\e[0m");
        }
        $this->printMigrationsStack($res);
        if($this->_confirmMigration()){
            $this->_rollback($res);
        }
    }

    protected function _rollback(\core\orm\Queryset $res): void{
        foreach($res as $migration){
            $this->printStatus("\n\e[33mRolling back ".$migration->name.' ...');
            $path = implode(DIRECTORY_SEPARATOR, [$this->getMigrationLocation(), $migration->name.'.php']);
            if(!is_readable($path)){
                throw new Exception("Migration ".$path." isn't readable or doesn't exists");
            }
            require_once $path;
            $class_name = "Migration_".$migration->name;
            $obj = new $class_name();
            $obj->revert();
            models\MigrationModel::_remove($migration->id);
            $this->printStatus("\t\e[0m[\e[32mOK\e[0m]", False);
        }
    }

    private function _getMigrationsStack(string $target): \core\orm\Queryset{
        if(!empty($target)){
            $cond = "cast(name as unsigned) >= (SELECT cast(name as unsigned) FROM abt_migrations WHERE name = :target) ORDER BY name desc";
            $res = models\MigrationModel::_filter($cond, ['target' => $target]);
        } else {
            $res = models\MigrationModel::_last(1);
        }
        return $res;
    }

    private function _confirmMigration(): bool{
        $answer = readline("Continue [y/N]: ");
        return mb_strtolower($answer) == 'y';
    }

    private function printMigrationsStack(\core\orm\Queryset $migrations): void{
        $this->printStatus("\n\e[33mNext migrations will be rolled back: \e[0m");
        $mig_list = [];
        foreach($migrations as $idx => $migration){
            $mig_list[] = "\n\t".$migration->name;
        }
        $this->printList($mig_list);
    }

    protected function printStatus(string $status, bool $new_line=true){
        if($new_line){
            echo PHP_EOL;
        }
        echo $status;
    }

    protected function printList(array $list): void{
        foreach($list as $item){
            echo $item;
        }
        echo PHP_EOL;
    }
}

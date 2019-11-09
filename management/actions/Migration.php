<?php declare(strict_types=1);
namespace management\actions;
use \management as manage;
use \management\migration as mig;
use \management\interfaces as iface;
use \core\models;
use \management\Arguments;

final class Migration extends manage\ConsoleAction{
    const name = 'migration';
    const desc = 'Database management tool';

    public function run(iface\IArguments $args): void{
        $this->actions->addAction(mig\Help::factory());
        $this->actions->addAction(mig\Create::factory());
        $this->actions->addAction(mig\ListUnapplied::factory());
        $this->actions->addAction(mig\Migrate::factory());
        $this->actions->addAction(mig\Log::factory());
        $this->actions->addAction(mig\Rollback::factory());
        $this->actions->addAction(mig\Redo::factory());
        $this->actions->addAction(mig\Fake::factory());

        if(!models\MigrationModel::table_exists()){
            $this->createMigrationsTable();
        }

        parent::run($args);
    }

    protected function createMigrationsTable(){
        $q="CREATE TABLE abt_migrations(
            id int PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) not null,
            create_date datetime not null,
            create_user varchar(255) not null
        )";
        $this->query($q, []);
    }
}

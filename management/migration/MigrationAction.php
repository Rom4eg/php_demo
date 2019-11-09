<?php
namespace management\migration;
use \management as manage;


class MigrationAction extends manage\ConsoleAction{
    const isfinal = True;

    protected function getMigrationLocation(): string{
        return implode(DIRECTORY_SEPARATOR, [BASE_DIR, 'management', 'migration', 'migrations']);
    }
}

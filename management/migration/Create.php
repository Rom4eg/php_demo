<?php
namespace management\migration;
require_once BASE_DIR.'/SmartyTemplate.php';
use \management\interfaces as iface;
use \core\sanitizer\Sanitizer;

/**
 * Migartion command.
 * Create new migration
 */
class Create extends MigrationAction{

    const name = 'create';
    const desc = 'create empty migration.';
    protected $args = ['name'];

    /**
     * Migration name
     * @var string
     */
    protected $name = '';

    /**
     * File path to migration directory
     * @var string
     */
    protected $path = '';

    /**
     * Migration template path. e.g. templates/management/migration.tpl
     * @var string
     */
    protected $template = 'management/migration/templates/migration.tpl';

    /**
     * {@inheritDoc}
     */
    public function run(iface\IArguments $args): void{
        $args = new \Ds\Vector($args->getArguments());
        $machine_name = preg_replace('/-/', '_', php_uname("n"));
        $timestamp = date('U');
        $salt = md5($timestamp.$machine_name);
        $input_name = Sanitizer::create($args->shift())->notNull('Migration')->sanitize();
        $this->name = implode('_', [$timestamp, $input_name, $salt]);

        $smarty = \SmartyTemplate::create();
        $smarty->assign('name',$this->name);
        $tpl = $smarty->fetch($this->template);
        $file_name = implode(DIRECTORY_SEPARATOR, [$this->getMigrationLocation(), $this->name]);

        $status = '';
        try{
            file_put_contents($file_name.'.php', $tpl);
            $status = $this->getSucessText();
        } catch(\Exception $e){
            $status = $this->getErrorText($e->getMessage());
        }
        $this->printStatus($status);
    }

    /**
     * Get command readable status
     * @return string text representation
     */
    public function getSucessText(): string{
        return "\n\e[33mCreated new migration ".$this->name."\e[0m\n";
    }

    public function getErrorText(string $errtext): string{
        return "\n\e[31mUnable to create migration due: ".$errtext."\e[0m\n";
    }

    public function printStatus(string $status): void{
        echo $status;
    }
}

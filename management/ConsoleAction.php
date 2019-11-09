<?php declare(strict_types=1);
namespace management;
require_once BASE_DIR.'/include/database/PDOMixin.php';
use \management\interfaces as iface;
use \management\Arguments;


/**
 * Abstract Console Action
 */
abstract class ConsoleAction extends \PDOMixin implements iface\IAction{

    /**
     * Command name
     * @var string
     */
    const name = 'command';

    /**
     * command description
     * @var string
     */
    const desc = '';

    /**
     * Final action flag.
     * @var boolean
     */
    const isfinal = False;

    /**
     * Command arguments
     * @var array
     */
    protected $args = [];

    /**
     * Command actions
     * @var iface\IActionContainer
     */
    protected $actions = null;

    /**
     * Entry point
     * @param iface\IArguments $args
     */
    public function run(iface\IArguments $args): void{
        if($this->actions->hasAction($args->getCommand())){
            $act = $this->actions->getAction($args->getCommand());
            if(!$act->isFinal()){
                $args = $this->getNextRoute($args);
            }
            $act->run($args);
        } else {
            $this->doesntExist();
        }
    }

    /**
     * {@inheritDoc}
     * @param  iface\IArguments $args
     * @return iface\IArguments
     */
    public function getNextRoute(iface\IArguments $args): iface\IArguments{
        return Arguments::create($args->getArguments());
    }

    /**
     * Constructor
     */
    public function __construct(iface\IActionContainer $cont){
        $this->actions = $cont;
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    public function doesntExist(): void{
        echo PHP_EOL."Command doesn't exists".PHP_EOL;
    }

    /**
     * {@inheritDoc}
     * @return iface\IActionContainer actions
     */
    public function getActions(): iface\IActionContainer{
        return $this->actions;
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getDescription(): string{
        return static::desc;
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getName(): string{
        return static::name;
    }

    /**
     * {@inheritDoc}
     * @return array command args
     */
    public function getArgs(): array{
        return $this->args;
    }

    /**
     * Factory method
     * @return iface\IAction
     */
    public static function factory(): iface\IAction{
        $cont = new ActionContainer();
        return new static($cont);
    }

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function isFinal(): bool{
        return static::isfinal;
    }
}

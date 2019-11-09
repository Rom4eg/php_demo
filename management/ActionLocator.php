<?php
namespace management;
use management\interfaces as iface;

/**
 * Action locator
 */
class ActionLocator implements iface\IActionLocator{

    /**
     * Singletone container
     * @var iface\IActionLocator
     */
    protected static $inst = null;

    /**
     * ActionContainer
     * @var iface\IActionContainer
     */
    protected $container = null;

    /**
     * Constructor
     * @param iface\IActionContainer $cont container for actions
     */
    private function __construct(iface\IActionContainer $cont){
        $this->container = $cont;
    }

    /**
     * {@inheritDoc}
     */
    public static function getInstance(bool $force_new=False): iface\IActionLocator{
        if($force_new){
            static::$inst = null;
        }

        if(!static::$inst){
            $cont = new ActionContainer();
            static::$inst = new static($cont);
        }
        return static::$inst;
    }

    /**
     * {@inheritDoc}
     * @param iface\IManagementAction $act action
     */
    public static function addAction(iface\IAction $act): void{
        $obj = static::getInstance();
        $obj->getActions()->addAction($act);
    }

    /**
     * {@inheritDoc}
     * @return ifaceIActionContainer all action container
     */
    public function getActions(): iface\IActionContainer{
        return $this->container;
    }
}

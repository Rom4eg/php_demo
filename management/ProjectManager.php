<?php

declare(strict_types=1);

namespace management;

use \Ds\Vector;
use \management\interfaces as iface;
use \management\Arguments;

/**
 * Default Project manager
 * 
 * @category Management
 * @package Management
 * @author Roman Paranichev <rparanichev@.ru>
 */
class ProjectManager implements iface\IProjectManager
{

    /**
     * Arguments container
     * 
     * @var iface\IArguments
     */
    protected $container = '';

    /**
     * Locator
     * 
     * @var iface\IActionLocator
     */
    protected $locator = null;

    /**
     * Constructor
     * 
     * @param iface\IArguments $cont argv
     */
    public function __construct(iface\IArguments $cont)
    {
        $this->container = $cont;
    }

    /**
     * {@inheritDoc}
     * 
     * @param iface\IActionLocator $locator fction locator
     * 
     * @return void
     */
    public function setLocator(iface\IActionLocator $locator): void
    {
        $this->locator = $locator;
    }

    /**
     * {@inheritDoc}
     * 
     * @return iface\IActionLocator
     */
    public function getLocator(): iface\IActionLocator
    {
        return $this->locator;
    }

    /**
     * {@inheritDoc}
     * 
     * @return void
     */
    public function runCommand(): void
    {
        $act_list = $this->getLocator()->getActions();
        $cmd = $this->getArgsCont()->getCommand();
        if ($act_list->hasAction($cmd)) {
            $cmd_obj = $act_list->getAction($cmd);
            $cont = $this->container;
            if (!$cmd_obj->isFinal()) {
                $cont = $this->createArgsContainer();
            }
            $cmd_obj->run($cont);
        } else {
            $this->doesntExists();
        }
    }

    /**
     * Factory
     * 
     * @param iface\IArguments $container arguments container
     * 
     * @return iface\IProjectManager
     */
    public static function create(iface\IArguments $container): iface\IProjectManager
    {
        $obj = new static($container);
        $obj->setLocator(ActionLocator::getInstance());
        return $obj;
    }

    /**
     * {@inheritDoc}
     * 
     * @return iface\IArguments
     */
    public function createArgsContainer(): iface\IArguments
    {
        return Arguments::create($this->container->getArguments());
    }

    /**
     * {@inheritDoc}
     * 
     * @return iface\IArguments
     */
    public function getArgsCont(): iface\IArguments
    {
        return $this->container;
    }

    /**
     * {@inheritDoc}
     * 
     * @return void
     */
    public function doesntExists(): void
    {
        echo PHP_EOL . "Command doesn't exists" . PHP_EOL;
    }
}

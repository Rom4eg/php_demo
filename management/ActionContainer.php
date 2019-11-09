<?php declare(strict_types=1);
namespace management;
use \management\interfaces as iface;
use \core\generics\CollectionMixin;

/**
 * List of actions
 */
class ActionContainer implements iface\IActionContainer{
    use CollectionMixin;

    /**
     * container
     * @var array
     */
    protected $task_list = [];

    /**
     * {@inheritDoc}
     */
    public function addAction(iface\IAction $act): void{
        assert(!array_key_exists($act->getName(), $this->task_list));
        $this->task_list[$act->getName()] = $act;
    }

    /**
     * {@inheritDoc}
     * @param  string $name action name
     * @return bool
     */
    public function hasAction(string $name): bool{
        return array_key_exists($name, $this->task_list);
    }

    /**
     * {@inheritDoc}
     * @param string $name action name
     */
    public function removeAction(string $name): void{
        assert(array_key_exists($name, $this->task_list));
        unset($this->task_list[$name]);
    }

    /**
     * {@inheritDoc}
     * @param  string $name name of the required task
     * @return iface\IManagementAction
     */
    public function getAction(string $name): iface\IAction{
        assert(array_key_exists($name, $this->task_list));
        return $this->task_list[$name];
    }

    /**
     * CollectionMixin abstract
     * @return array
     */
    public function getCollection(): array{
        return $this->task_list;
    }
}

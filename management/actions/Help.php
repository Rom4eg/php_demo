<?php
namespace management\actions;
use \management as manage;
use \management\interfaces as iface;


class Help extends manage\ConsoleAction{

    const name = 'help';
    const desc = 'show this message and exit';
    const isfinal = True;

    /**
     * Help msg constructor
     */
    public function run(iface\IArguments $args): void{
        echo $this->getTitle().PHP_EOL;

        $actions_list = $this->getActions();
        if(count($actions_list)){
            echo "Available commands:".PHP_EOL;
            echo PHP_EOL;
            foreach($actions_list->getCollection() as $param){
                $args_str = $this->_formatArgsOutput($param->getArgs());
                printf($this->getOutputMask($actions_list), $param->getName(), $args_str, $param->getDescription());
            }
            echo PHP_EOL;
        }
    }

    public function getActions(): iface\IActionContainer{
        return manage\ActionLocator::getInstance()->getActions();
    }

    /**
     * Format string mask for help output
     * @return string mask
     */
    final private function getOutputMask(iface\IActionContainer $actions): string{
        $cmd_len = 5;
        $args_len = 10;
        foreach($actions as $param){
            $name_len = mb_strlen($param->getName());
            if($name_len > $cmd_len){
                $cmd_len = $name_len;
            }

            $params_len = mb_strlen($this->_formatArgsOutput($param->getArgs()));
            if($params_len > $args_len){
                $args_len = $params_len;
            }
        }
        return "\n\t%-".$cmd_len."s %-".$args_len."s - %s";
    }

    /**
     * Pretty print for param arguments
     * @param  array $args Param arguments
     * @return string ' [arg1] [arg2] ... [argN]'
     */
    final private function _formatArgsOutput(array $args): string{
        $formated_args = [];
        foreach($args as $arg){
            $formated_args[] = sprintf('[%s]', $arg);
        }
        return implode(' ', $formated_args);
    }

    protected function getTitle(): string{
        return 'AbtronicsCRM management tool';
    }
}

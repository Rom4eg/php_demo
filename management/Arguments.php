<?php declare(strict_types=1);
namespace management;
use \management as manage;
use \management\interfaces as iface;
use \core\validator\rules;
use \core\sanitizer\Sanitizer;


/**
 * Action arguments container.
 */
class Arguments implements iface\IArguments{

    /**
     * Command for current action
     * @var string
     */
    protected $command = '';

    /**
     * list of arguments
     * @var array
     */
    protected $arguments = [];

    /**
     * Constructor
     * @param string $cmd command
     * @param array  $args command arguments
     */
    private function __construct(string $cmd, array $args){
        $this->command = $cmd;
        $this->arguments = $args;
    }

    /**
     * {@inheritDoc}
     * @return string
     */
    public function getCommand(): string{
        return $this->command;
    }

    /**
    * {@inheritDoc}
    * @return string
    */
    public function getArguments(): array{
        return $this->arguments;
    }

    /**
     * Convert container to array
     * @return array
     */
    public function toArray(): array{
        $arr = $this->arguments;
        array_unshift($arr, $this->command);
        return $arr;
    }

    /**
     * Factory. Sanitize and create container
     * @param array $args list of user input
     * @return iface\IArguments
     */
    public static function create(array $args): iface\IArguments{
        $args = Sanitizer::create($args)->notNull([])->array()->length('min', 2, '')->sanitize();
        $cmd = Sanitizer::create(array_shift($args))->notNull('help')->sanitize();
        return new static($cmd, $args);
    }
}

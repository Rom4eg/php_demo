<?php declare(strict_types=1);
namespace core\acl\rules;
use \core\acl\interfaces as iface;

class Contains implements iface\IRule{

    /**
     * Compared values
     * @var mixed
     */
    protected $values;

    public function __construct(array $values){
        $this->values = $values;
    }

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function compare(): bool{
        foreach($this->values as $expected => $real){
            if(!in_array($expected, $real)){
                return False;
            }
        }
        return True;
    }
}

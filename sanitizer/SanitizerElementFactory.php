<?php
namespace core\sanitizer;
use \core\sanitizer\interfaces as iface;
use \core\sanitizer\elements as el;


class SanitizerElementFactory{

    /**
     * Factory. Create any Sanitizer element.
     * @var string $type element type
     * @var array $args element arguments
     */
    public static function create(string $type, array $args): iface\ISanitizerElement{
        switch($type){
            case el\ArrayLength::class:
                return new el\ArrayLength(...$args);
            case el\NotNull::class:
                return new el\NotNull(...$args);
            case el\IsArray::class:
                return new el\IsArray(...$args);
            case el\IsInteger::class:
                return new el\IsInteger(...$args);
            case el\IsString::class:
                return new el\IsString(...$args);
            default:
                throw new \Exception("Undefined type");
        }
    }
}

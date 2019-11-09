<?php

/**
 * Integer sanitizer
 */

declare(strict_types=1);

namespace core\sanitizer\elements;

use \core\sanitizer\interfaces\ISanitizerElement;

/**
 * Try cast value to integer
 * 
 * @package Core\Sanitizer
 * @author Roman Paranichev <rparanichev@.ru>
 */
class IsInteger implements ISanitizerElement
{
    protected $base;

    /**
     * Constructor
     * 
     * @param int $base base number system
     */
    public function __construct(int $base)
    {
        $this->base = $base;
    }

    /**
     * Entry point
     * 
     * @param mixed $value source val
     * 
     * @return int
     */
    public function sanitize($value): int
    {
        return intval($value, $this->base);
    }
}

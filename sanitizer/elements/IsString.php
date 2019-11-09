<?php

/**
 * String sanitizer
 */

declare(strict_types=1);

namespace core\sanitizer\elements;

use \core\sanitizer\interfaces\ISanitizerElement;

/**
 * Try cast value to string
 * 
 * @package Core\Sanitizer
 * @author Roman Paranichev <rparanichev@.ru>
 */
class IsString implements ISanitizerElement
{

    /**
     * Entry point
     * 
     * @param mixed $value source val
     * 
     * @return string
     */
    public function sanitize($value): string
    {
        return strval($value);
    }
}

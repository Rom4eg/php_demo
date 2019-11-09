<?php
namespace core\sanitizer;
use \core\sanitizer\interfaces as iface;
use \core\sanitizer\elements as el;
use Exception;

class Sanitizer implements iface\ISanitizer{

    protected $sanitizers = null;

    protected $val = '';

    public function __construct($val)
    {
        $this->val = $val;
        $this->sanitizers = new \Ds\Vector();
    }

    public function length(string $border, int $border_val, $placceholder): iface\ISanitizer{
        $element = SanitizerElementFactory::create(el\ArrayLength::class, [$border, $border_val, $placceholder]);
        $this->addElement($element);
        return $this;
    }

    public function notNull($placceholder): iface\ISanitizer{
        $element = SanitizerElementFactory::create(el\NotNull::class, [$placceholder]);
        $this->addElement($element);
        return $this;
    }

    public function array(): iface\ISanitizer{
        $element = SanitizerElementFactory::create(el\IsArray::class, []);
        $this->addElement($element);
        return $this;
    }
    
    public function integer(int $base=10): iface\ISanitizer{
        $element = SanitizerElementFactory::create(el\IsInteger::class, [$base]);
        $this->addElement($element);
        return $this;
    }

    public function string(): iface\ISanitizer{
        $element = SanitizerElementFactory::create(el\IsString::class, []);
        $this->addElement($element);
        return $this;
    }

    public static function create($value): iface\ISanitizer{
        $inst = new static($value);
        return $inst;
    }

    public function sanitize()
    {
        $val = $this->val;
        foreach ($this->sanitizers as $elem) {
            $val = $elem->sanitize($this->val);
        }
        return $val;
    }

    protected function addElement(iface\ISanitizerElement $elem): void{
        $this->sanitizers->push($elem);
    }
}

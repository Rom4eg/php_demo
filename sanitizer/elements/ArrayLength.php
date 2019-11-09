<?php
namespace core\sanitizer\elements;
use \core\sanitizer\interfaces as iface;


class ArrayLength implements iface\ISanitizerElement{

    const MIN = 'min';
    const MAX = 'max';
    const EXACT = 'exact';

    protected $border;
    protected $border_val;
    protected $placeholder;

    public function __construct(string $border, int $border_val, $placeholder){
        $this->border = $border;
        $this->border_val = $border_val;
        $this->placeholder = $placeholder;
    }

    public function sanitize($value){
        switch($this->border){
            case self::MIN:
                return $this->sanitize_min($value);
            case self::MAX:
                return $this->sanitize_max($value);
            case self::EXACT:
                $value = $this->sanitize_min($value);
                return $this->sanitize_max($value);
            default:
                throw new \Exception("Incorrect type");
        }
    }

    protected function sanitize_max(array $val): array{
        if(count($val) > $this->border_val){
            $val = array_slice($val, 0, $this->border_val);
        }
        return $val;
    }

    protected function sanitize_min(array $val): array{
        if(count($val) < $this->border_val){
            foreach(range(1, ($this->border_val - count($val))) as $iter_index){
                $val[] = $this->placeholder;
            }
        }
        return $val;
    }
}

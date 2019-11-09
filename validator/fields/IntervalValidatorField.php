<?php
namespace core\validator\fields;
use Exception;

class IntervalValidatorField extends FloatValidatorField{

    protected $interval = [];

    public function __construct($value=null, $interval=[], $empty=false, $cast=true){
        if(empty($interval) || count($this->interval) != 2 || !is_numeric($this->interval[0]) || !is_numeric($this->interval[1])){
            throw new Exception("Interval field required array of exactly 2 numbers.");
        }
        $this->interval = $interval;
        parent::__construct($value, $empty, $cast);
    }

    public function clean(){
        $value = parent::clean();
        if($value >= $this->interval[0] && $value <= $this->interval[1]){
            return $value;
        }
        throw new Exception("Значение должно быть в интервале от ".$this->interval[0].' до '.$this->interval[1]);
    }
}


?>

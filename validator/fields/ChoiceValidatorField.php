<?php
namespace core\validator\fields;
use Exception;

class ChoiceValidatorField extends AbstractValidatorField{

    protected $choice = [];

    public function __construct($choice=[], $value=null, $empty=false){
        $this->choice = $choice;
        parent::__construct((array)$value, $empty);
    }

    public function clean(){
        $value = parent::clean();
        if(in_array($value, $this->choice)){
            return $value;
        }
        throw new Exception("The value must be one of ".implode(',', $this->choice));
    }
}


?>

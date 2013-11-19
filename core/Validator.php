<?php

class Validator
{

    /**
     *
     * @var array The validation rules
     */
    private $rules = array();

    /**
     *
     * @var array The validation errors 
     */
    private $errors = array();

    
    
    
    
    
    /**
     * Add a rule to the validator
     * 
     * @param array $rule The rule
     */
    public function addRules($field, $rules) {

    }

    /**
     * Remove a rule from the validator
     * 
     * @param string $field
     */
    public function removeRules($field) {
        unset($this->rules[$field]);
    }

    
    
    /**
     * Run the validation
     * 
     * @return boolean
     */
    function run() {
        var_dump($this->rules);
    }

    
   
}
<?php
/*
 *  Author: Ronash Dhakal
 *  Project: Guest Registration System
 *  
 */

class Validate {

    private $_passed = false,
            $_errors = array(),
            $_db = NULL;

    public function __construct() {
        $this->_db = DB::getIntance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                // echo "{$item} {$rule} must be {$rule_value} <br>";
                $value = trim($source[$item]);
                $item = escape($item);
                
                if ($rule == 'required' && empty($value)) {
                    $this->addError("".ucfirst($item)." is required");
                } else if (!empty($rule)) {
                    switch ($rule) {
                        case 'min':
                            if(strlen($value)< $rule_value){
                                $this->addError("".ucfirst($item)." must be a minium of {$rule_value} lenght");
                            }

                            break;
                        case 'max':
                             if(strlen($value)> $rule_value){
                                $this->addError("".ucfirst($item)." must be a maximum of {$rule_value} length");
                            }
                            break;

                        case 'matches':
                            if($value !=$source[$rule_value]){
                                $this->addError("".ucfirst($rule_value)."must match {$item}");
                            }
                            break;
                     
                        case 'unique':
                            $check = $this->_db->get($rule_value,array($item,'=',$value));
                            if($check->count()){
                                $this->addError("".ucfirst($item)." already exists!");
                            }
                            break;
                            
                        case 'phone':
                            if( $rule = $rule_value && !preg_match('/^\d+$/',$value)){
                               
                                    $this->addError("".ucfirst($item)." is invalid!");
                                
                            }
                            break;
                        case 'realname':
                            if($rule = $rule_value && !preg_match('/^(?:[A-Za-z]+(?:\s+|$)){2,3}$/',$value)) {
                                $this->addError("You must provide your real name!");
                              }
                            break;
                        case 'nospace':
                            if($rule = $rule_value && preg_match('/\s/',$value)) {
                                $this->addError("".ucfirst($item)." should not have any white space!");
                              }
                            break;
                            
                        case 'alphanumeric':
                            if($rule = $rule_value && preg_match('/^\d+$/',$value)){
                              $this->addError("".ucfirst($item)." is invalid!");  
                            }
                            break;

                        default:
                            break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}

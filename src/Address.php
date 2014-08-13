<?php

namespace DDM\SmartyStreets;

class Address{
  public $street;
  public $street2;
  public $secondary;
  public $city;
  public $state;
  public $zipcode;
  public $addressee;

  public function __construct(array $addressInfo){
    foreach($this->getClassVars() as $field){
      if(isset($addressInfo[$field])){
        $this->{$field} = $addressInfo[$field];
      }
    }
  }

  public function getClassVars(){
    return array_keys($this->toArray());
  }

  public function toArray(){
    return get_object_vars(($this));
  }
}

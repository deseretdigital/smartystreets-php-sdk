<?php

namespace DDM\SmartyStreets;

abstract class AbstractResponse
{
  protected $body = '';

  public function __construct($body = '')
  {
    $this->body = $body;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }
  
  abstract public function isValid();

}

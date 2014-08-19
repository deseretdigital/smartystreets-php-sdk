<?php

namespace DDM\SmartyStreets;

class ValidatedAddress
{

  protected $address;
  protected $candidates = [];


  public function __construct($address, $candidates = [])
  {
      $this->address = $address;
      $this->candidates = $candidates;
  }

  public function hasCandidates()
  {
    return (count($this->candidates) > 0);
  }

  public function addCandidate(AddressCandidate $candidate)
  {
    $this->candidates[] = $candidate;
  }

  public function setCandidates($candidateArray)
  {
    foreach($candidateArray as $candidate){
      $this->addCandidate($candidate);
    }
  }
}

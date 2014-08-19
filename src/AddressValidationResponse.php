<?php

namespace DDM\SmartyStreets;

class AddressValidationResponse extends AbstractResponse
{
  protected $validatedAddresses = [];
  protected $candidates = [];

  public function isValid()
  {
    $valid = true;
    if(count($this->getValidatedAddresses()) == 0){
      $valid = false;
    }
    if($valid){
      foreach($this->validatedAddresses as $address){
        if(!$address->hasCandidates()){
          return false;
        }
      }
    }
    return $valid;
  }

  public function mergeAddressesWithResults($addresses)
  {
    foreach($addresses as $index => $address)
    {
      $validatedAddress = new ValidatedAddress($address);
      $validatedAddress->setCandidates($this->findCandidates($index));
      $validatedAddresses[]=$validatedAddress;
    }

    return $validatedAddresses;
  }

  public function findCandidates($index)
  {
    $candidates = $this->getCandidates();
    $matches = [];
    foreach($candidates as $candidate){
      if($candidate->getInputIndex() == $index)
      {
        $matches[]=$candidate;
      }
    }
    return $matches;
  }

  public function getCandidates()
  {
    if($this->body && !$this->candidates)
    {
      foreach($this->body as $body)
      {
        $candidate = new AddressCandidate();
        $candidate->setFromObject($body);
        $this->candidates[]=$candidate;
      }
    }
    return $this->candidates;
  }

  public function getValidatedAddresses(){
    if(!$this->validatedAddresses){
      $this->validatedAddresses = $this->mergeAddressesWithResults($this->addresses);
    }
    return $this->validatedAddresses;
  }

  public function setAddresses($addresses){
    $this->addresses = $addresses;
  }
}

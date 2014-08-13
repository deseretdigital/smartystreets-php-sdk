<?php

namespace DDM\SmartyStreets;

class AddressValidationRequest extends AbstractRequest
{
  protected $endpoint  = 'street-address';
  protected $addresses = [];

  public function addAddress(Address $address)
  {
    $this->addresses[]=$address;
  }

  public function getAddresses()
  {
      return $this->addresses;
  }

  protected function getBody()
  {
    $body = json_encode($this->addresses);
    return $body;
  }

  public function validateAddresses()
  {
      $response = $this->send();
      $response->setAddresses($this->getAddresses());
      return $response;
  }

  public function getDefaultResponse()
  {
    return new AddressValidationResponse();
  }
}

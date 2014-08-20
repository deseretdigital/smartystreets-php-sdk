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
	$addressToArray = array();
	foreach($this->addresses as $address) {
	  $addressToArray[] = $address->toArray();
	}

	$body = json_encode($addressToArray);
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

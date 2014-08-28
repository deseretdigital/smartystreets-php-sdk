<?php

namespace DDM\SmartyStreets;

class AddressValidationRequest extends AbstractRequest
{
    protected $endpoint  = 'street-address';
    protected $addresses = array();

    /**
     * Adds address to be validated
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
      $this->addresses[] = $address;
    }

    /**
     * Getter for addresses
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Sends Address to be validated
     * @return AddressResponse
     */
    public function validateAddresses()
    {
        $this->setBody($this->getSerializeAddresses());

        $response = $this->send();
        $response->setAddresses($this->getAddresses());
        return $response;
    }

    /**
     * Returns default AddressValidationReponse
     * @return AddressValidationResponse
     */
    public function getDefaultResponse()
    {
        return new AddressValidationResponse();
    }

    /**
     * Json encodes address objects
     * @return string json encoded array of address
     */
    public function getSerializeAddresses()
    {
        $addressesCollection = array();

        foreach ($this->addresses as $address) {
            $addressesCollection[] = $address->toArray();
        }

        return json_encode($addressesCollection);
    }
}

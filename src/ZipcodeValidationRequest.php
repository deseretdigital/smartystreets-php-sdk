<?php

namespace DDM\SmartyStreets;


use DDM\SmartyStreets\ZipcodeValidationResponse;

class ZipcodeValidationRequest extends AbstractRequest
{
    protected $endpoint  = 'zipcode';
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
        return new ZipcodeValidationResponse();
    }

    /**
     * Json encodes address objects
     * @return string json encoded array of address
     */
    public function getSerializeAddresses()
    {
        $addressesCollection = array();

        foreach ($this->addresses as $address) {
            $addressesCollection[] = $this->getZipcodeFields($address);
        }

        return json_encode($addressesCollection);
    }

    /**
     * Filter out other address fields
     * @param  Address $address
     * @return array zipcode fiels (city,state,zipcode)
     */
    public function getZipcodeFields($address)
    {
        $includeFields = array(
            'city'      => 1,
            'state'     => 1,
            'zipcode'   => 1,
        );

        $zipcodeData = array_intersect_key($address->toArray(), $includeFields);

        return $zipcodeData;
    }
}

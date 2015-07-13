<?php

namespace DDM\SmartyStreets;

class AddressValidationRequest extends AbstractRequest
{
    protected $endpoint  = 'street-address';
    protected $addresses = array();
    protected $candidates = 1;

    /**
     * Adds address to be validated
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
    }

    /**
     * Set the number of candidates to get for each address
     *
     * @param int  $num  Number of candidates
     */
    public function setNumberOfCandidates($num)
    {
        $this->candidates = $num;
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
     * @return AddressValidationResponse
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
            $addressesCollection[] = array_merge(['candidates' => $this->candidates], $address->toArray());
        }

        return json_encode($addressesCollection);
    }
}

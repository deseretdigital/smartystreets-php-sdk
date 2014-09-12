<?php

namespace DDM\SmartyStreets;

use DDM\SmartyStreets\ZipcodeCandidate as Candidate;
use DDM\SmartyStreets\Address;
use DDM\SmartyStreets\ValidatedAddress;

class ZipcodeValidationResponse extends AbstractResponse implements ValidationResponseInterface
{

    /**
     * City
     * @var string
     */
    protected $city;

    /**
     * State
     * @var string
     */
    protected $state;

    /**
     * StateAbbreviation
     * @var string
     */
    protected $stateAbbreviation;

    /**
     * Validated Zipcodes
     * @var array
     */
    protected $candidates = array();

    /**
     * Getter for city
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Setter for city
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Getter for state
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Setter for state
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Getter for stateAbbreviation
     * @return string
     */
    public function getStateAbbreviation()
    {
        return $this->stateAbbreviation;
    }

    /**
     * Setter for stateAbbreviation
     * @param string $stateAbbreviation
     */
    public function setStateAbbreviation($stateAbbreviation)
    {
        $this->stateAbbreviation = $stateAbbreviation;
    }

    /**
     * Setter for candidates
     * @param array $candidates
     */
    public function setCandidates($candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * Set properties from smarty street response object
     * @param stdClass $object
     */
    public function setFromObject($object)
    {
        if (isset($object[0]->city_states)) {
            $cityObject = $object[0]->city_states[0];

            $data = array(
                'city'              => isset($cityObject->city) ? $cityObject->city : null,
                'state'             => isset($cityObject->state) ? $cityObject->state : null,
                'stateAbbreviation' => isset($cityObject->state_abbreviation) ? $cityObject->state_abbreviation : null
            );

            $this->setData($data);
        }

        if (isset($object[0]->zipcodes)) {
            $zipcodes   = $object[0]->zipcodes;
            $inputIndex = $object[0]->input_index;

            $zipcodeCandidates = array();
            foreach ($zipcodes as $zipcodeObject) {
                $zipcodeObject->input_index = $inputIndex;
                $zipcodeCandidates[] = new Candidate($zipcodeObject);
            }

            $this->setCandidates($zipcodeCandidates);
        }
    }

    /**
     * Takes object and transforms it to array
     * @return [type] [description]
     */
    public function toArray()
    {
        $data = parent::toArray();
        if (isset($data['candidates'])) {

            $zipcodeCandidates = array();
            foreach ($data['candidates'] as $zipcode) {
                $zipcodeCandidates[] = $zipcode->toArray();
            }

            $data['candidates'] = $zipcodeCandidates;
        }

        return $data;
    }

    /**
     * Query function to see if we recieved any candidates from smartyStreets
     * @return boolean true if there is atleast one zipcode candidate false otherwise
     */
    public function hasCandidates()
    {
        return count($this->candidates) > 0;
    }

    /**
     * Query function to see if city/ state /zipcode is valid
     * @return boolean true if there is atleast one zipcode false otherwise
     */
    public function isValid()
    {
        return $this->hasCandidates();
    }

    /**
     * Returns array of validated addresses
     * @return
     */
    public function getValidatedAddresses()
    {
        if(!$this->validatedAddresses) {
            $this->validatedAddresses = $this->mergeAddressesWithResults($this->addresses);
        }

        return $this->validatedAddresses;
    }

    public function mergeAddressesWithResults($addresses)
    {
        foreach($addresses as $index => $address) {
            $validatedAddress = new ValidatedAddress($address);

            $validatedAddress->setCandidates($this->findCandidates($index));

            $validatedAddresses[] = $validatedAddress;
        }

        return $validatedAddresses;
    }

    public function findCandidates($index)
    {
        $candidates = $this->getCandidates();

        $matches = array();
        foreach($candidates as $candidate) {
            if($candidate->getInputIndex() == $index) {
                $matches[] = $candidate;
            }
        }

        return $matches;
    }

    /**
     * Getter for candidates
     * @return array
     */
    public function getCandidates()
    {
        $this->checkCorrectResponse();

        if(empty($this->candidates) && $this->checkCorrectResponse()) {
            $this->setFromObject($this->getBody());
        }

        return $this->candidates;
    }

    public function setAddresses($addresses) {
        $this->addresses = $addresses;
    }

    protected function checkCorrectResponse()
    {
        $object = current($this->body);
        return isset($object->status) ? false : true;
    }
}

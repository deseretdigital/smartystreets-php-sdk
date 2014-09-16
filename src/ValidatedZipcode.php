<?php

namespace DDM\SmartyStreets;

class ValidatedZipcode extends AbstractModel
{

    /**
     * Origional address
     * @var Address
     */
    protected $address;

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
     * Array of AddressCadidate objects
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
     * Getter for cadidates
     * @return array
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * Query method for determining if we have candidates
     * @return boolean
     */
    public function hasCandidates()
    {
        return (count($this->candidates) > 0);
    }

    /**
     * Getter for address
     * @return Address Origional address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Setter for address
     * @param array $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Takes object and transforms it to array
     * @return [type] [description]
     */
    public function toArray()
    {
        $data = parent::toArray();

        if (isset($data['address'])) {
            $data['address'] = $data['address']->toArray();
        }

        if (isset($data['candidates'])) {
            $zipcodeCandidates = array();
            foreach ($data['candidates'] as $zipcode) {
                $zipcodeCandidates[] = $zipcode->toArray();
            }

            $data['candidates'] = $zipcodeCandidates;
        }

        return $data;
    }
}

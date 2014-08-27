<?php

namespace DDM\SmartyStreets;

class ValidatedAddress
{

    /**
     * Origional address
     * @var Address
     */
    protected $address;

    /**
     * Array of AddressCadidate objects
     * @var array
     */
    protected $candidates = array();


    public function __construct($address, $candidates = array())
    {
        $this->address = $address;
        $this->candidates = $candidates;
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
     * Getter for cadidates
     * @return array
     */
    public function getCandidates()
    {
        return $this->candidates;
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

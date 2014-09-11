<?php

namespace DDM\SmartyStreets;

class ZipcodeCandidate
{
    protected $inputIndex;
    protected $cityStates;
    protected $zipcodes;

    /**
     * Sets properties using smartystreets response object
     *
     * Supported fields for $object
     * -
     * - inputIndex           = int
     * - cityStates           = object
     * - zipcodes             = object
     *
     * @param object $object smartystreets response object
     */
    public function setFromObject($object)
    {
        $this->inputIndex = $object->input_index;
        $this->cityStates = $object->city_states;
        $this->zipcodes   = $object->zipcodes;
    }

    /**
     * Getter for city_states object
     *
     * Component fields:
     * -
     * - city                = string
     * - state_abbreviation  = string
     * - state               = string
     *
     * @return object contains all city_states info (city, state, zipcode)
     */
    public function getCityStates()
    {
        return $this->cityStates[0];
    }

    /**
     * Getter for zipcode
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcodes[0]->zipcode;
    }

    /**
     * Getter for zipcode type
     * @return string
     */
    public function getZipcodeType()
    {
        return $this->zipcodes[0]->zipcode_type;
    }

    /**
     * Getter for county fips
     * @return string
     */
    public function getCountyFips()
    {
        return $this->zipcodes[0]->county_fips;
    }

    /**
     * Getter for county name
     * @return string
     */
    public function getCountyName()
    {
        return $this->zipcodes[0]->county_name;
    }

    /**
     * Getter for latitude
     * @return float
     */
    public function getLatitude()
    {
        return $this->zipcodes[0]->latitude;
    }

    /**
     * Getter for longitude
     * @return float
     */
    public function getLongitude()
    {
        return $this->zipcodes[0]->longitude;
    }

    /**
     * Setter for zipcode
     *
     * @param string
     */
    public function setZipcode($zipcode)
    {
        $this->zipcodes[0]->zipcode = $zipcode;
    }

    /**
     * Setter for zipcode type
     *
     * @param string
     */
    public function setZipcodeType($zipcodeType)
    {
        $this->zipcodes[0]->zipcode_type = $zipcodeType;
    }

    /**
     * Setter for county fips
     *
     * @param string
     */
    public function setCountyFips($countyFips)
    {
        $this->zipcodes[0]->county_fips = $countyFips;
    }

    /**
     * Setter for county name
     *
     * @param string
     */
    public function setCountyName($countyName)
    {
        $this->zipcodes[0]->county_name = $countyName;
    }

    /**
     * Setter for latitude
     *
     * @param float
     */
    public function setLatitude($latitude)
    {
        $this->zipcodes[0]->latitude = $latitude;
    }

    /**
     * Setter for longitude
     *
     * @param float
     */
    public function setLongitude($longitude)
    {
        $this->zipcodes[0]->longitude = $longitude;
    }

    /**
    * Returns Address object from candidate data
    * @return Address
    */
    public function getAddress()
    {
        $cityStates = $this->getCityStates();

        $address = new Address(array(
            'street'  => null,
            'street2' => null,
            'city'    => $cityStates->city,
            'state'   => $cityStates->state_abbreviation,
            'zipcode' => $this->getZipcode(),
            'secondary' => null,
            'addressee' => null
        ));

        return $address;
    }
}

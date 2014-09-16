<?php

namespace DDM\SmartyStreets;


class ZipcodeCandidate extends AbstractModel
{
    protected $inputIndex;
    protected $zipcode;
    protected $zipcodeType;
    protected $countyFips;
    protected $countyName;
    protected $latitude;
    protected $longitude;

    /**
     * Extend default constructor to provide setFromObject
     * @param mixed $data
     */
    public function __construct($data=array())
    {
        if (is_object($data)) {
            $this->setFromObject($data);
        } else {
            parent::__construct($data);
        }
    }

    /**
     * Sets properties using smartystreets response object
     *
     * Supported fields for $object
     * -
     *
     *
     *
     * @param object $object smartystreets response object
     */
    public function setFromObject($object)
    {
        $data = array(
            'inputIndex'  => isset($object->input_index) ? $object->input_index : null,
            'zipcode'     => isset($object->zipcode) ? $object->zipcode : null,
            'zipcodeType' => isset($object->zipcode_type) ? $object->zipcode_type : null,
            'countyFips'  => isset($object->county_fips) ? $object->county_fips : null,
            'countyName'  => isset($object->county_name) ? $object->county_name : null,
            'latitude'    => isset($object->latitude) ? $object->latitude : null,
            'longitude'   => isset($object->longitude) ? $object->longitude : null
        );

        $this->setData($data);
    }

    /**
     * Getter for inputIndex
     * @return int Input position
     */
    public function getInputIndex()
    {
        return $this->inputIndex;
    }

    /**
     * Setter for inputIndex
     */
    public function setInputIndex($inputIndex)
    {
        $this->inputIndex = $inputIndex;
    }

    /**
     * Getter for zipcode_type
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Setter for zipcode
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Getter for zipcodeType
     * @return string
     */
    public function getZipcodeType()
    {
        return $this->zipcodeType;
    }

    /**
     * Setter for zipcodeType
     * @param string $zipcodeType
     */
    public function setZipcodeType($zipcodeType)
    {
        $this->zipcodeType = $zipcodeType;
    }

    /**
     * Getter for countyFips
     * @return string
     */
    public function getCountyFips()
    {
        return $this->countyFips;
    }

    /**
     * Setter for countyFips
     * @param string $countyFips
     */
    public function setCountyFips($countyFips)
    {
        $this->countyFips = $countyFips;
    }

    /**
     * Getter for countyName
     * @return string
     */
    public function getCountyName()
    {
        return $this->countyName;
    }

    /**
     * Setter for countyName
     * @param string $countyName
     */
    public function setCountyName($countyName)
    {
        $this->countyName = $countyName;
    }

    /**
     * Getter for latitude
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Setter for latitude
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Getter for longitude
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Setter for longitude
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Convenience method for extracting both lat and lon
     * @return array
     */
    public function getLatAndLong()
    {
        return array(
          'latitude'  => $this->getLatitude(),
          'longitude' => $this->getLongitude(),
        );
    }
}

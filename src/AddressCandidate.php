<?php

namespace DDM\SmartyStreets;

class AddressCandidate
{
    protected $candidateIndex;
    protected $inputIndex;
    protected $inputId;

    protected $addressee;
    protected $deliveryLine1;
    protected $deliveryLine2;
    protected $lastLine;

    protected $deliveryPointBarcode;
    protected $components;
    protected $metadata;
    protected $analysis;

    /**
     * Sets properties using smartystreets response object
     *
     * Supported fields for $object
     * -
     * - inputId              = mixed
     * - inputIndex           = int
     * - candidateIndex       = int
     * - addressee            = string
     * - deliveryLine1        = string
     * - deliveryLine2        = string
     * - lastLine             = string
     * - deliveryPointBarcode = string
     * - components           = object
     * - metadata             = object
     * - analysis             = object
     *
     * @param object $object smartystreets response object
     */
    public function setFromObject($object)
    {
        $this->inputId              = isset($object->input_id) ? $object->input_id : null;
        $this->inputIndex           = $object->input_index;
        $this->candidateIndex       = $object->candidate_index;
        $this->addressee            = isset($object->addressee) ? $object->addressee : null;
        $this->deliveryLine1        = $object->delivery_line_1;
        $this->deliveryLine2        = isset($object->delivery_line_2) ? $object->delivery_line_2 : null;
        $this->lastLine             = $object->last_line;
        $this->deliveryPointBarcode = $object->delivery_point_barcode;
        $this->components           = $object->components;
        $this->metadata             = $object->metadata;
        $this->analysis             = $object->analysis;
    }

    /**
     * Convenience method for extracting both lat and lon
     * @return array
     */
    public function getLatAndLong()
    {
        return [
          'latitude'  => $this->getLatitude(),
          'longitude' => $this->getLongitude(),
        ];
    }

    /**
     * Getter for canditatIndex
     * @return int Posistion in smartystreets response
     */
    public function getCandidateIndex()
    {
        return $this->candidateIndex;
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
     * Getter for inputId
     * @return string input id passed to smartystreets
     */
    public function getInputId()
    {
        return $this->inputId;
    }

    /**
     * Getter for addressee
     * @return string
     */
    public function getAddressee()
    {
        return $this->addressee;
    }

    /**
     * Getter for deliveryLine1
     * @return  string
     */
    public function getDeliveryLine1()
    {
        return $this->deliveryLine1;
    }

    /**
     * Getter for deliveryLine2
     * @return  string
     */
    public function getDeliveryLine2()
    {
        return $this->deliveryLine2;
    }

    /**
     * Getter for lastLine
     * @return  string
     */
    public function getLastLine()
    {
        return $this->lastLine;
    }

    /**
     * Getter for deliveryPointBarcode
     * @return  string
     */
    public function getDeliveryPointBarcode()
    {
        return $this->deliveryPointBarcode;
    }

    /**
     * Getter for components object
     *
     * Component fields:
     * -
     * - primary_number             = string
     * - street_predirection        = string
     * - street_name                = string
     * - street_suffix              = string
     * - city_name                  = string
     * - state_abbreviation         = string
     * - zipcode                    = string
     * - plus4_code                 = string
     * - delivery_point             = string
     * - delivery_point_check_digit = string
     *
     * @return object contains all candidat address components (ie city, state, zipcode etc)
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
    * Returns Address object from candidate data
    * @return Address
    */
    public function getAddress()
    {
        $components = $this->getComponents();

        $address = new Address(array(
            'street'  => $this->getDeliveryLine1(),
            'street2' => $this->getDeliveryLine2(),
            'city'    => $components->city_name,
            'state'   => $components->state_abbreviation,
            'zipcode' => $components->zipcode,
            'secondary' => null,
            'addressee' => $this->getAddressee()
        ));

        return $address;
    }

    /**
     * Getter for metadata
     *
     * Metadata fields:
     * -
     * - record_type            = string
     * - zip_type               = string
     * - county_fips            = string
     * - county_name            = string
     * - carrier_route          = string
     * - congressional_district = string
     * - rdi                    = string
     * - elot_sequence          = string
     * - elot_sort              = string
     * - latitude               = float
     * - longitude              = float
     * - precision              = string
     * - time_zone              = string
     * - utc_offset             = float
     * - dst                    = bool
     *
     * @return object
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Getter for analysis
     *
     * Analysis fields:
     * -
     * - dpv_match_code = string
     * - dpv_footnotes  = string
     * - dpv_cmra       = string
     * - dpv_vacant     = string
     * - active         = string
     * - footnotes      = string
     *
     * @return [type] [description]
     */
    public function getAnalysis()
    {
        return $this->analysis;
    }

    /**
     * Getter for latitude
     * @return float
     */
    public function getLatitude()
    {
        return $this->metadata->latitude;
    }

    /**
     * Getter for longitude
     * @return float
     */
    public function getLongitude()
    {
        return $this->metadata->longitude;
    }

}

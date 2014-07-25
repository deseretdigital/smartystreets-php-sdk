<?php

namespace DDM\Api\SmartyStreets;

class SmartyStreetsClient
{

    protected $_authId = 'auth-id';

    protected $_authToken = 'auth-token';

    protected $_url = 'https://api.smartystreets.com/street-address/';

    protected $_ch;

    public function __construct() {
        // Initialize cURL
        $this->_ch = curl_init();

        // Configure the cURL command
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_POST, true);
        curl_setopt($this->_ch, CURLOPT_HEADER, 0);
        //curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array('x-standardize-only: true'));    // Enable this line if you want to only standardize addresses that are "good enough"
        curl_setopt($this->_ch, CURLOPT_VERBOSE, 0);
        curl_setopt($this->_ch, CURLOPT_URL, $this->_url . '?auth-id=' .$this->_authId . '&auth-token=' . $this->_authToken);
    }

    public function geocode($locations) {
        if (!is_array($locations) || count($locations)>100) {
            $error = 'Input array is too large';
            return $error;
        }

        $json_input = json_encode($locations);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $json_input);

        // Output comes back as a JSON string.
        //$json_output = curl_exec($this->_ch);

        $json_output = '
        [
            {
                "input_index": 0,
                "candidate_index": 0,
                "addressee": "Apple Inc"
                "delivery_line_1": "1 Infinite Loop",
                "delivery_line_2": "PO Box 42",
                "last_line": "Cupertino CA 95014-2083",
                "delivery_point_barcode": "950142083017",
                "components": {
                    "primary_number": "1",
                    "street_name": "Infinite",
                    "street_suffix": "Loop",
                    "city_name": "Cupertino",
                    "state_abbreviation": "CA",
                    "zipcode": "95014",
                    "plus4_code": "2083",
                    "delivery_point": "01",
                    "delivery_point_check_digit": "7"
                },
                "metadata": {
                    "record_type": "S",
                    "county_fips": "06085",
                    "county_name": "Santa Clara",
                    "carrier_route": "C067",
                    "congressional_district": "15",
                    "rdi": "Commercial",
                    "latitude": 37.33118,
                    "longitude": -122.03062,
                    "precision": "Zip9"
                },
                "analysis": {
                    "dpv_match_code": "Y",
                    "dpv_footnotes": "AABB",
                    "dpv_cmra": "N",
                    "dpv_vacant": "N",
                    "active": "Y"
                }
            }
        ]
        ';

        $results = json_decode($json_output);

        return $results;
    }

}
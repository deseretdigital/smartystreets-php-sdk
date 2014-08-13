<?php

use DDM\SmartyStreets\AddressCandidate as Candidate;

class AddressCandidateTest extends PHPUnit_Framework_TestCase
{
  public function testLatitudeAndLongitude()
  {
    $responseJson = $this->getValidResponseJson();

    $candidate = new Candidate();
    $candidate->setFromObject(json_decode($responseJson)[0]);
    $latLongArray = [
      "latitude" => "37.33118",
      "longitude"=> "-122.03062",
    ];
    $result = $candidate->getLatAndLong();
    $this->assertEquals($latLongArray, $result, 'should be the same');
  }


  public function getValidResponseJson()
  {
    $responseJson = '[
      {
        "input_index": 0,
        "candidate_index": 1,
        "addressee": "Apple Inc",
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
    ]';
    return $responseJson;
  }
}

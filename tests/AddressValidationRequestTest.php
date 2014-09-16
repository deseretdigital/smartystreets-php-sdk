<?php

namespace DDM\SmartyStreets;

use DDM\SmartyStreets\AddressValidationRequest;
use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Stream\Stream;


class AddressValidationRequestTest extends \PHPUnit_Framework_TestCase
{

  public function setUp()
  {
    $this->guzzleClientMock = \Mockery::mock('\\Guzzle\\HTTP\\Client');
    $this->guzzleRequestMock = \Mockery::mock('\\Guzzle\\Http\\Message\\Request');
    $this->guzzleResponseMock = \Mockery::mock('\\Guzzle\\Http\\Message\\Response');

    $this->smartyRequest = new AddressValidationRequest('','', $this->guzzleClientMock);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {
      \Mockery::close();
  }

  public function testDefaultClient()
  {
    $smartyRequest = new AddressValidationRequest('','');
    $client = $smartyRequest->getClient();

    $this->assertTrue($client instanceof GuzzleClient);
  }

  public function testSetClient()
  {
    $guzzleClient = $this->guzzleClientMock;

    $smartyRequest = $this->smartyRequest;
    $smartyRequest->setClient($guzzleClient);

    $this->assertEquals($guzzleClient, $smartyRequest->getClient());
  }

  public function testAddAddress()
  {
    $smartyRequest = $this->smartyRequest;
    $address = new Address(array());

    $smartyRequest->addAddress($address);
    $addressCount = count($smartyRequest->getAddresses());

    $this->assertEquals(1, $addressCount, 'should have exactly one address');
  }

  public function testValidateAddress()
  {
    // arrange

    $smartyRequest = $this->smartyRequest;
    $guzzleClient = $this->guzzleClientMock;
    $guzzleRequest = $this->guzzleRequestMock;
    $guzzleResponse = $this->guzzleResponseMock;

    $rawResponse = '[
  {
    "input_index": 0,
    "candidate_index": 0,
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


    $guzzleResponse->shouldReceive('getBody')->once()
      ->andReturn($rawResponse);

    $guzzleRequest->shouldReceive('send')->once()
      ->andReturn($guzzleResponse);

    $guzzleClient->shouldReceive('post')->once()
      ->andReturn($guzzleRequest);

    // act

    $addressArray = json_decode(
  	  '{
    	 	"addressee": "Apple Inc",
    		"street": "1 infinite loop",
    		"street2": "po box 42",
    		"city": "cupertino",
    		"state": "ca",
    		"zipcode": "95014",
	      "candidates": 10
	    }',true
    );
    $address = new Address($addressArray);

    $smartyRequest->addAddress($address);
    $validatedAddresseResponse = $smartyRequest->validateAddresses();

    // assert
    $this->assertTrue($validatedAddresseResponse->isValid(), 'response should be valid');
  }


}

<?php
use \DDM\SmartyStreets\Address as Address;
use \DDM\SmartyStreets\AddressValidationRequest as Request;

$authId = '556a7d9d-cfb2-462c-9647-f1e7796ef499';
$authToken = 'eI2WlLHizcFvZrya0fZc';
$addressArray = [
  'street' => '1020 Mountain Shadow Dr',
  'city'   => 'Layton',
  'state'  => 'Utah',
  'zipcode' => '84040',
];

$address = new Address($addressArray);
$request =  new Request($authToken, $authId);
$request->addAddress($address);

$validatedAddressResponse = $request->validateAddresses();

dd($validatedAddressResponse->getValidatedAddresses());

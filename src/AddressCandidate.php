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


  public function __construct()
  {

  }

  public function setFromObject($object)
  {
    $this->inputId = isset($object->input_id) ? $object->input_id : null;
    $this->inputIndex = $object->input_index;
    $this->candidateIndex = $object->candidate_index;
    $this->addressee = $object->addressee;
    $this->deliveryLine1 = $object->delivery_line_1;
    $this->deliveryLine2 = $object->delivery_line_2;
    $this->lastLine = $object->last_line;
    $this->deliveryPointBarcode = $object->delivery_point_barcode;
    $this->components = $object->components;
    $this->metadata = $object->metadata;
    $this->analysis = $object->analysis;
  }

  public function getLatAndLong()
  {
    return [
      'latitude' => $this->getLatitude(),
      'longitude' => $this->getLongitude(),
    ];
  }

  public function getCandidateIndex()
  {
    return $this->candidateIndex;
  }
  public function getInputIndex()
  {
    return $this->inputIndex;
  }
  public function getInputId()
  {
    return $this->inputId;
  }

  public function getAddressee()
  {
    return $this->addressee;
  }
  public function getDeliveryLine1()
  {
    return $this->deliveryLine1;
  }
  public function getDeliveryLine2()
  {
    return $this->deliveryLine2;
  }
  public function getLastLine()
  {
    return $this->lastLine;
  }

  public function getDeliveryPointBarcode()
  {
    return $this->deliveryPointBarcode;
  }
  public function getComponents()
  {
    return $this->components;
  }
  public function getMetadata()
  {
    return $this->metadata;
  }
  public function getAnalysis()
  {
    return $this->analysis;
  }

  public function getLatitude()
  {
    return $this->metadata->latitude;
  }

  public function getLongitude()
  {
    return $this->metadata->longitude;
  }

}

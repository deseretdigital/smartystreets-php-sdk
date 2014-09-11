<?php

namespace DDM\SmartyStreets;

interface ValidationResponseInterface
{
    public function isValid();
    public function getCandidates();
    public function getValidatedAddresses();
}

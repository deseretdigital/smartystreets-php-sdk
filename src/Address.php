<?php

namespace DDM\SmartyStreets;

class Address{
    protected $street;
    protected $street2;
    protected $secondary;
    protected $city;
    protected $state;
    protected $zipcode;
    protected $addressee;

    public function __construct(array $addressInfo){
        $this->setData($addressInfo);
    }

    /**
     * Getter for street
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Setter for street
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

        /**
         * Getter for street2
         * @return string
         */
        public function getStreet2()
        {
            return $this->street2;
        }

        /**
         * Setter for street2
         * @param string $street2
         */
        public function setStreet2($street2)
        {
            $this->street2 = $street2;
        }

        /**
         * Getter for secondary
         * @return string
         */
        public function getSecondary()
        {
            return $this->secondary;
        }

        /**
         * Setter for secondary
         * @param string $secondary
         */
        public function setSecondary($secondary)
        {
            $this->secondary = $secondary;
        }

        /**
         * Getter for city
         * @return string
         */
        public function getCity()
        {
            return $this->city;
        }

        /**
         * Setter for city
         * @param string $city
         */
        public function setCity($city)
        {
            $this->city = $city;
        }

        /**
         * Getter for state
         * @return string
         */
        public function getState()
        {
            return $this->state;
        }

        /**
         * Setter for state
         * @param string $state
         */
        public function setState($state)
        {
            $this->state = $state;
        }

        /**
         * Getter for zipcode
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
     * Getter for addressee
     * @return string
     */
    public function getAddressee()
    {
        return $this->addressee;
    }

    /**
     * Setter for addressee
     * @param string $addressee
     */
    public function setAddressee($addressee)
    {
        $this->addressee = $addressee;
    }

    public function getClassVars(){
        return array_keys($this->toArray());
    }

    /**
     * Set class data using an array
     * Supported fields for data:
     * -
     * - street    = string
     * - street2   = string
     * - secondary = string
     * - city      = string
     * - state     = string
     * - zipcode   = array
     * - addressee = array
     *
     * @param array $data
     *
     * @return self implement fluent interface
     */
    public function setData(array $data)
    {
        foreach($data as $key => $value) {
            if(isset($key)){
                $setter = 'set' . $key;
                if(method_exists($this, $setter)) {
                    $this->$setter($value);
                }
            }
        }
        return $this;
    }

    /**
     * Converts Address into Array
     * @return array
     */
    public function toArray()
    {
      $properties = get_object_vars($this);
      $data = array();
      foreach($properties as $key => $value) {

            $getter = 'get' . $key;
            if(method_exists($this, $getter)){
                $data[$key] = $this->$getter();
            }
      }

      return $data;
    }
}

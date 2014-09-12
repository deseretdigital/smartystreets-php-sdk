<?php

namespace DDM\SmartyStreets;

abstract class AbstractModel
{

    /**
     * General use constructor
     * @param array $data [description]
     */
    public function __construct($data=array()){
        $this->setData($data);
    }

    /**
     * General perpose set data that will map
     * a data array to corresponding setter method
     *
     * Supported format for $data:
     * <pre>
     * array(
     *     {property} => {value}
     * )
     * </pre>
     *
     * @param array $data [description]
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
     * Converts model into Array
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
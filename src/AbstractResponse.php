<?php

namespace DDM\SmartyStreets;

abstract class AbstractResponse extends AbstractModel
{
    protected $body = '';

    /**
     * Getter for body
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Setter for body
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }




}

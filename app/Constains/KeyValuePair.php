<?php

namespace App\Constains;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class KeyValuePair
{
    public $userobject = array();

    public function __construct()
    {
        $this->addArray();
    }

    public function getArray($key)
    {
        $value = Arr::only($this->userobject, $key);
        return $value;
    }

    private function addArray()
    {
        $this->userobject = [];
    }
}

<?php

namespace App\Library\BarCharts;

class MetaDashboard
{
    protected $getArray;

    public function __construct($getArray = [])
    {
    	$this->getArray = $getArray;
    }

    public function getMetaDashboard()
    {
    	$getCountWithinLimit = [];
        $getCountOutOfLimit = [];

        foreach ($this->getArray as $key => $value) {
        	if (isset($value["monitoring_status"])) {
        		if (strtolower($value["monitoring_status"]) == "within limit") {
	                array_push($getCountWithinLimit, $value);
	            } else {
	                array_push($getCountOutOfLimit, $value);
	            }
        	} elseif (isset($value["monitor_status"])) {
        		if (strtolower($value["monitor_status"]) == "within limit") {
	                array_push($getCountWithinLimit, $value);
	            } else {
	                array_push($getCountOutOfLimit, $value);
	            }
        	}
        }

        $dataMeta = [
            count($getCountWithinLimit) > 0 ? (count($getCountWithinLimit) / (count($getCountWithinLimit) + count($getCountOutOfLimit))) * 100 : 0,
            count($getCountOutOfLimit) > 0 ? (count($getCountOutOfLimit) / (count($getCountOutOfLimit) + count($getCountWithinLimit))) * 100 : 0,
        ];

        return $dataMeta;
    }
}

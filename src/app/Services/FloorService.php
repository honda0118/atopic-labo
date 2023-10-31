<?php

namespace App\Services;

class FloorService
{
    /**
     * 指定した小数点以下を切り捨てる
     * 
     * @access public
     * @param  int $places
     * @param  int|float $value
     * @return int|float
     */
    public static function roundDown(int $places, $value)
    {
        $exponentiation = pow(10, $places);
        return floor($value * $exponentiation) / $exponentiation;
    }
}

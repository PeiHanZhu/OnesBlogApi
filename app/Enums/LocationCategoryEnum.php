<?php

namespace App\Enums;

class LocationCategoryEnum
{
    const RESTAURANTS = 1;
    const SPOTS = 2;
    const LODGINGS = 3;

    public static function getAllCategoryValues() {
        $oClass = new \ReflectionClass(__CLASS__);
        return array_values($oClass->getConstants());
    }
}

<?php

namespace App\Enums;

class LocationCategoryEnum
{
    const RESTAURANTS = 1;
    const SPOTS = 2;
    const LODGINGS = 3;

    public static function constants()
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }

    public static function values()
    {
        return array_values(self::constants());
    }
}

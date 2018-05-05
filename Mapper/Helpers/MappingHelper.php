<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper\Helpers;

use Illuminate\Support\Carbon;

class MappingHelper
{


    public static function dateMapping($attributeName, $timezone = 'UTC')
    {
        return self::indirectDdateMapping($attributeName, $attributeName, $timezone);
    }


    public static function indirectDdateMapping($sourceAttributeName, $targetAttributeName, $timezone = 'UTC', $format = 'd. M. Y H:i')
    {
        return function ($source, $target) use ($sourceAttributeName, $targetAttributeName, $timezone, $format) {
            $attr = Carbon::parse($source->$sourceAttributeName);
            $target->$targetAttributeName = $attr->timezone($timezone)->format($format);
        };
    }

    static public function integerPriceMapping($attributeName = 'price')
    {
        return function ($source, $target) use ($attributeName) {
            $target->$attributeName = intval($source->$attributeName);
        };
    }
}
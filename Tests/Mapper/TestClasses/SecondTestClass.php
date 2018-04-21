<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


class SecondTestClass
{
    public $firstAttribute;
    public $secondAttributeDifferent;
    public $thirdAttribute;

    public function __construct($first = null, $second = null, $third = null)
    {
        $this->firstAttribute = $first;
        $this->secondAttributeDifferent = $second;
        $this->thirdAttribute = $third;
    }

    public static function createEmpty()
    {
        return new self(null, null, null);
    }

    public static function createWithFirstAttrAs($first)
    {
        return new self($first);
    }

    public static function createWithEachAttrAs($each)
    {
        return new self($each, $each, $each);
    }

    public static function createWithEachAttrDifferent($prefix)
    {
        return new self($prefix.'_frst', $prefix.'_scnd', $prefix.'_thrd');
    }
}
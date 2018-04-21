<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;

class ThirdTestClass implements IMappable
{

    public $firstAttribute;
    public $secondAttribute;
    public $thirdAttributeDifferent;

    public function __construct($first = null, $second = null, $third = null)
    {
        $this->firstAttribute = $first;
        $this->secondAttribute = $second;
        $this->thirdAttributeDifferent = $third;
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

    /**
     * Mapping collection to use with @see SecondTestClass with switched map roles (this class as target).
     *
     * @return IMappingCollection
     */
    static function getMappingCollection(): IMappingCollection
    {
        return MappingCollectionBuilder::create()
            ->addDirectMapping('firstAttribute')
            ->addIndirectMapping('secondAttributeDifferent', 'secondAttribute')
            ->addIndirectMapping('thirdAttribute', 'thirdAttributeDifferent')
            ->build();

    }
}
<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;

class SixthTestClass implements IMappable
{
    public $firstAttributeDiff;
    public $secondAttributeDiff;
    /**
     * @var FirstTestClass
     */
    public $thirdAttributeDiff;

    public function __construct($first = null, $second = null, $third = null)
    {
        $this->firstAttributeDiff = $first;
        $this->secondAttributeDiff = $second;
        $this->thirdAttributeDiff = $third;
    }

    public static function createEmpty()
    {
        return new self(null, null, null);
    }

    public static function createWithThirdAttrAs($third)
    {
        return new self(null, null, $third);
    }


    /**
     * Mapping collection to use with @see SecondTestClass.
     *
     * @return IMappingCollection
     */
    static function getMappingCollection(): IMappingCollection
    {
        return MappingCollectionBuilder::create()
            ->addDirectMapping('firstAttributeDiff')
            ->addIndirectMapping('secondAttributeDiff', 'thirdAttribute')
            ->addNestedIndirectMapping('thirdAttributeDiff', 'secondAttribute', FirstTestClass::class, SecondTestClass::class)
            ->build();
    }
}
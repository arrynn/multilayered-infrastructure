<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;

class FifthTestClass
{
    public $firstAttributeDiff;
    /**
     * @var SecondTestClass $secondAttribute
     */
    public $secondAttribute;
    public $thirdAttribute;

    public function __construct($first = null, $second = null, $third = null)
    {
        $this->firstAttributeDiff = $first;
        $this->secondAttribute = $second;
        $this->thirdAttribute = $third;
    }

    public static function createEmptyWithInnerObject()
    {
        return new self(null, SecondTestClass::createEmpty(), null);
    }


    public static function createEmpty()
    {
        return new self(null, null, null);
    }

}
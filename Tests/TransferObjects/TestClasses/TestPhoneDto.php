<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollectionBuilder;

/**
 * Class TestPhoneDto
 * @package Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses
 *
 * @property string $country_code
 * @property string $number
 */
class TestPhoneDto implements IResolvableDto, IMappable
{

    static function getAttributeCollection(): DtoAttributeCollection
    {
        return DtoAttributeCollectionBuilder::create()
            ->addPrimitive('country_code')
            ->addPrimitive('number')
            ->build();
    }

    public static function getFillExample()
    {
        return [
            'country_code' => '552',
            'number' => '454856214'
        ];
    }

    static function getMappingCollection(): IMappingCollection
    {
        /**
         * mapping from @see TestAddressModel
         */
        return MappingCollectionBuilder::create()
            ->addDirectMapping('country_code')
            ->addDirectMapping('number')
            ->build();
    }
}
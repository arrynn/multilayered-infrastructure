<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestAddressModel;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollectionBuilder;

/**
 * Class TestAddressDto
 * @package Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses
 *
 * @property string $street
 * @property string $street_number
 * @property string $zip
 * @property string $city
 * @property string $country
 */
class TestAddressDto implements IResolvableDto, IMappable
{

    static function getAttributeCollection(): DtoAttributeCollection
    {
        return DtoAttributeCollectionBuilder::create()
            ->addPrimitive('street')
            ->addPrimitive('street_number')
            ->addPrimitive('zip')
            ->addPrimitive('city')
            ->addPrimitive('country')
            ->build();
    }

    public static function getFillExample()
    {
        return [
            'street' => 'Landside Rd.',
            'street_number' => '102c',
            'zip' => '1078 01',
            'city' => 'Worlhinki',
            'country' => 'Asgard'
        ];
    }

    static function getMappingCollection(): IMappingCollection
    {
        /**
         * mapping from @see TestAddressModel
         */
        return MappingCollectionBuilder::create()
            ->addDirectMapping('street')
            ->addDirectMapping('street_number')
            ->addDirectMapping('zip')
            ->addDirectMapping('city')
            ->addDirectMapping('country')
            ->build();
    }
}
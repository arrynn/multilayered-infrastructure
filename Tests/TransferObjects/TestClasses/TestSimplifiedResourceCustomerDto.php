<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestAddressModel;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestCustomerModel;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestPhoneModel;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollectionBuilder;
use Illuminate\Support\Carbon;

/**
 * Class TestSimplifiedResourceCustomerDto
 * @package Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses
 *
 * @property string $full_name
 * @property string $email
 * @property TestAddressDto $address
 * @property TestPhoneDto[] $phones
 * @property string $created_at
 */
class TestSimplifiedResourceCustomerDto implements IMappable, IResolvableDto
{

    static function getMappingCollection(): IMappingCollection
    {
        return MappingCollectionBuilder::create()
            ->addCustomMapping(self::getNamePropertyMapping())
            ->addDirectMapping('email')
            ->addNestedDirectMapping('address', TestAddressModel::class, TestAddressDto::class)
            ->addNestedDirectMapping('phones', TestPhoneModel::class, TestPhoneDto::class)
            ->addCustomMapping(self::getDatePropertyMapping('created_at'))
            ->build();
    }

    private static function getNamePropertyMapping()
    {
        /**
         * @param TestCustomerModel $source
         * @param TestSimplifiedResourceCustomerDto $target
         */
        return function ($source, $target) {
            $target->full_name = $source->name . ' ' . $source->surname;
        };
    }

    private static function getDatePropertyMapping($attrName)
    {
        /**
         * @param TestCustomerModel $source
         * @param TestSimplifiedResourceCustomerDto $target
         */
        return function ($source, $target) use ($attrName) {
            /**
             * @var Carbon $date
             */
            $date = $source->$attrName;
            $target->$attrName = Carbon::createFromFormat('Y-m-d H:i:s', $date, 'UTC')
                ->timezone(config('app.output_timezone'))
                ->format('d. M Y H:i');
        };
    }


    static function getAttributeCollection(): DtoAttributeCollection
    {
        return DtoAttributeCollectionBuilder::create()
            ->addPrimitive('full_name')
            ->addPrimitive('email')
            ->addComplex('address', TestAddressDto::class)
            ->addComplexArray('phones', TestPhoneDto::class)
            ->addPrimitive('created_at')
            ->build();

    }
}
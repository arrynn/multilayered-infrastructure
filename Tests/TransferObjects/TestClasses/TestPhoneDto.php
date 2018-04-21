<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


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
class TestPhoneDto implements IResolvableDto
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
}
<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollectionBuilder;

/**
 * Class TestCustomerDto
 * @package Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses
 *
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property TestAddressDto $address
 * @property TestPhoneDto[] $phones
 */
class TestCustomerDto implements IResolvableDto
{

    static function getAttributeCollection(): DtoAttributeCollection
    {
        return DtoAttributeCollectionBuilder::create()
            ->addPrimitive('name')
            ->addPrimitive('surname')
            ->addPrimitive('email')
            ->addComplex('address', TestAddressDto::class)
            ->addComplexArray('phones', TestPhoneDto::class)
            ->build();
    }

    public static function getFillExample()
    {
        return [
            'name' => 'Robert',
            'surname' => 'Rowlon',
            'email' => 'rowlon@robrow.io',
            'address' => TestAddressDto::getFillExample(),
            'phones' => [TestPhoneDto::getFillExample()]
        ];
    }

    public static function getFillExample2()
    {
        $example = self::getFillExample();
        $phoneExample = TestPhoneDto::getFillExample();
        $phoneExample['number'] = '650548922';
        $example['phones'][] = $phoneExample;
        return $example;
    }
}
<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\Unit;


use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestAddressDto;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestCustomerDto;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestPhoneDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoResolver;
use Tests\TestCase;

class TransferObjectsTest extends TestCase
{

    /**
     * @test
     */
    public function resolve_dtoWithOnlyPrimitiveAttributes_succeeds()
    {
        $phoneArray = TestPhoneDto::getFillExample();

        /**
         * @var TestPhoneDto $dto
         */
        $dto = DtoResolver::fromArray($phoneArray, new TestPhoneDto());

        self::assertEquals($dto->country_code, $phoneArray['country_code']);
        self::assertEquals($dto->number, $phoneArray['number']);
    }

    /**
     * @test
     */
    public function resolve_anotherDtoWithOnlyPrimitiveAttributes_succeeds()
    {
        $addressArray = TestAddressDto::getFillExample();

        /**
         * @var TestAddressDto $dto
         */
        $dto = DtoResolver::fromArray($addressArray, new TestAddressDto());

        self::assertEquals($dto->street, $addressArray['street']);
        self::assertEquals($dto->street_number, $addressArray['street_number']);
        self::assertEquals($dto->zip, $addressArray['zip']);
        self::assertEquals($dto->city, $addressArray['city']);
        self::assertEquals($dto->country, $addressArray['country']);
    }

    /**
     * @test
     */
    public function resolve_dtoWithOnlyPrimitiveAttributes_withMissingItemsInArray_succeeds()
    {
        $addressArray = TestAddressDto::getFillExample();
        unset($addressArray['country']);
        /**
         * @var TestAddressDto $dto
         */
        $dto = DtoResolver::fromArray($addressArray, new TestAddressDto());

        self::assertEquals($dto->street, $addressArray['street']);
        self::assertEquals($dto->street_number, $addressArray['street_number']);
        self::assertEquals($dto->zip, $addressArray['zip']);
        self::assertEquals($dto->city, $addressArray['city']);
        self::assertFalse(isset($dto->country));
    }

    /**
     * @test
     */
    public function resolve_dtoWithComplexAttributes_succeeds()
    {
        $customerArray = TestCustomerDto::getFillExample();

        /**
         * @var TestCustomerDto $dto
         */
        $dto = DtoResolver::fromArray($customerArray, new TestCustomerDto());

        self::assertTrue($dto->address instanceof TestAddressDto);
        self::assertTrue(count($dto->phones) == 1);
        self::assertTrue($dto->phones[0] instanceof TestPhoneDto);
        self::assertEquals($dto->phones[0]->country_code, $customerArray['phones'][0]['country_code']);
        self::assertEquals($dto->phones[0]->number, $customerArray['phones'][0]['number']);
    }

    /**
     * @test
     */
    public function resolve_anotherDtoWithComplexAttributes_succeeds()
    {
        $addressArray = TestCustomerDto::getFillExample2();

        /**
         * @var TestCustomerDto $dto
         */
        $dto = DtoResolver::fromArray($addressArray, new TestCustomerDto());

        self::assertTrue($dto->address instanceof TestAddressDto);
        self::assertTrue(count($dto->phones) == 2);
        $i = 1;
        self::assertTrue($dto->phones[$i] instanceof TestPhoneDto);
        self::assertEquals($dto->phones[$i]->country_code, $addressArray['phones'][$i]['country_code']);
        self::assertEquals($dto->phones[$i]->number, $addressArray['phones'][$i]['number']);
    }
}
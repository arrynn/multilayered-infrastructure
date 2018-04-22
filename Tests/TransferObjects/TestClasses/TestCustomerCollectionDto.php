<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses;


use Arrynn\MultilayeredInfrastructure\Mapper\Builder\MappingCollectionBuilder;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestAddressModel;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestCustomerModel;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestPhoneModel;
use Arrynn\MultilayeredInfrastructure\TransferObjects\ACollectionDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\CollectionDtoConfig;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollectionBuilder;
use Illuminate\Support\Carbon;


class TestCustomerCollectionDto extends ACollectionDto
{


    public function getCollectionConfig(): CollectionDtoConfig
    {
        return CollectionDtoConfig::create(TestCustomerModel::class, TestSimplifiedResourceCustomerDto::class);
    }
}
<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\Tests\Shared\Integration;


use Arrynn\MultilayeredInfrastructure\Mapper\Mapper;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\TestCustomerModel;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestAddressDto;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestCustomerCollectionDto;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestPhoneDto;
use Arrynn\MultilayeredInfrastructure\Tests\TransferObjects\TestClasses\TestSimplifiedResourceCustomerDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoResolver;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ResourceTransferObjectsTest extends TestCase
{

    private $sampleArray = [
        "full_name" => "Anthony Kipps",
        "email" => "antho.kipps@mailprovider.io",
        "address" => [
            "street" => "Main rd.",
            "street_number" => "102",
            "zip" => "0124 44",
            "city" => "Metropol",
            "country" => "Longtavernland",
        ],
        "phones" => [
            [
                "country_code" => "299",
                "number" => "949838272",
            ],
            [
                "country_code" => "301",
                "number" => "558448446",
            ]
        ],
        "created_at" => "18. Feb 2018 13:59"
    ];


    /**
     * @test
     */
    public function mapper_mapsCustomAttributesFromModelToDto_successfully()
    {
        $model = TestCustomerModel::sampleCustomer();
        $dto = new TestSimplifiedResourceCustomerDto();

        /**
         * @var TestSimplifiedResourceCustomerDto $res
         */
        $res = Mapper::map($model, $dto);
        self::assertEquals($model->name . ' ' . $model->surname, $res->full_name);
        self::assertEquals('18. Feb 2018 13:59', $res->created_at);
        self::assertTrue($res->address instanceof TestAddressDto);
        self::assertEquals(count($res->phones), 2);
        self::assertTrue($res->phones[0] instanceof TestPhoneDto);
        self::assertEquals($model->phones[0]->country_code, $res->phones[0]->country_code);
        self::assertEquals($model->phones[1]->country_code, $res->phones[1]->country_code);

    }

    /**
     * @test
     */
    public function resolver_resolvesDtoFromArray_successfully()
    {
        $array = $this->sampleArray;
        /**
         * @var TestSimplifiedResourceCustomerDto $res
         */
        $res = DtoResolver::fromArray($array, new TestSimplifiedResourceCustomerDto());

        self::assertEquals(count($res->phones), 2);
        self::assertTrue($res->phones[0] instanceof TestPhoneDto);
        self::assertTrue($res->address instanceof TestAddressDto);
        self::assertEquals($res->address->street_number, '102');
        self::assertEquals($res->phones[0]->country_code, '299');
        self::assertEquals($res->created_at, '18. Feb 2018 13:59');

        return $res;
    }

    /**
     * @test
     */
    public function resolverToArray_resolves_successfully(){
        $dto = $this->resolver_resolvesDtoFromArray_successfully();

        $sampleArrayCheck = md5(json_encode($this->sampleArray));

        $array = DtoResolver::toArray($dto);
        $arrayCheck = md5(json_encode($array));

        self::assertEquals($sampleArrayCheck, $arrayCheck);
    }

    /**
     * @test
     */
    public function resolverAndMapper_resolveAndMapFromPaginatorToCollectionDto_successfully()
    {
        $items = [
            TestCustomerModel::sampleCustomer(),
            TestCustomerModel::sampleCustomer(),
            TestCustomerModel::sampleCustomer(),
            TestCustomerModel::sampleCustomer(),
        ];
        $paginator = new LengthAwarePaginator($items, 4, 2);

        $collectionDto = new TestCustomerCollectionDto($paginator);

        $array = $collectionDto->toArray(null);
        self::assertEquals(4, count($array));
        foreach ($array as $item){
            self::assertEquals($item['phones'][0]['country_code'], '299');
        }


    }
}
<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


use Arrynn\MultilayeredInfrastructure\Mapper\Mapper;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Exceptions\DtoSettingException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ACollectionDto extends ResourceCollection
{
    public function __construct(LengthAwarePaginator $paginator)
    {
        parent::__construct($paginator);
    }

    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            $sourceObj = $item;
            $destObj = $this->getCollectionConfig()->getDestinationObj();
            $dto = Mapper::map($sourceObj, $destObj);
            return DtoResolver::toArray($dto);
        });
    }

    abstract public function getCollectionConfig(): CollectionDtoConfig;
}
<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\TransferObjects;

use Arrynn\MultilayeredInfrastructure\Mapper\Mapper;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class AResourceCollectionDto extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function ($item) {
            $baseDto = $this->getbaseDto();
            $dto = Mapper::map($item, get_class($baseDto));
            unset($baseDto);
            return $dto->asArray();
        });
    }

    abstract public function getbaseDto(): AResourceDto;
}
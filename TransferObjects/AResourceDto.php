<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\TransferObjects;

use Illuminate\Http\Resources\Json\Resource;

abstract class AResourceDto extends Resource
{
    public function toArray($request)
    {
        return $this->asArray();
    }

    abstract public function asArray(): array;
}
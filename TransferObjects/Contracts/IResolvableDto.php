<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts;


use Arrynn\MultilayeredInfrastructure\TransferObjects\DtoAttributeCollection;

interface IResolvableDto
{
    static function getAttributeCollection(): DtoAttributeCollection;
}
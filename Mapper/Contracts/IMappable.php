<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper\Contracts;


interface IMappable
{
    static function getMappingCollection(): IMappingCollection;
}
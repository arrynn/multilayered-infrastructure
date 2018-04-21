<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper\Contracts;


interface IMappingCollection
{
    /**
     * @return IMapping[]
     */
    public function all(): array;

    public function add(IMapping $mapping);
}
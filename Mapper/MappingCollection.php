<?php declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper;

use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMapping;
use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappingCollection;

class MappingCollection implements IMappingCollection
{

    /**
     * @var IMapping[]
     */
    private $mappings = [];

    /**
     * @return IMapping[]
     */
    public function all(): array
    {
        return $this->mappings;
    }

    /**
     * @param IMapping $mapping
     */
    public function add(IMapping $mapping)
    {
        $this->mappings[] = $mapping;
    }
}
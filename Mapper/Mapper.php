<?php declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper;


use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Exceptions\MappingException;

class Mapper
{

    /**
     * @param IMappable|mixed $source
     * @param IMappable|mixed $target
     * @return mixed
     * @throws MappingException if neither of the function call arguments implement the IMappable interface.
     */
    public static function map($source, $target)
    {
        $contractHolder = $source;
        if (!$source instanceof IMappable) {
            if (!$target instanceof IMappable) {
                throw new MappingException("At least one of provided objects for mapping must implement the IMappable contract");
            } else {
                $contractHolder = $target;
            }
        }

        $configuration = $contractHolder::getMappingCollection();
        $mappings = $configuration->all();
        foreach ($mappings as $mapping) {
            $closure = $mapping->getClosure();
            $closure($source, $target);
        }

        return $target;
    }
}
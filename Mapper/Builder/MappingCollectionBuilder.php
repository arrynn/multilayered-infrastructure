<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper\Builder;


use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMappable;
use Arrynn\MultilayeredInfrastructure\Mapper\Exceptions\MappingException;
use Arrynn\MultilayeredInfrastructure\Mapper\Mapper;
use Arrynn\MultilayeredInfrastructure\Mapper\Mapping;
use Arrynn\MultilayeredInfrastructure\Mapper\MappingCollection;
use Closure;
use Throwable;

class MappingCollectionBuilder
{
    private $collection;

    private function __construct()
    {
        $this->collection = new MappingCollection();
    }

    public static function create()
    {
        return new self();
    }

    public function addDirectMapping(string $attrName)
    {
        return $this->addIndirectMapping($attrName, $attrName);
    }

    public function addIndirectMapping(string $sourceAttr, string $destinationAttr)
    {
        $mapping = new Mapping();
        $closure = function ($source, $target) use ($sourceAttr, $destinationAttr) {
            try {
                if(isset($source->$sourceAttr)) {
                    $target->$destinationAttr = $source->$sourceAttr;
                }
            } catch (Throwable $e) {
                throw new MappingException("There was an error during mapping of attribute '$sourceAttr'"
                    . "in IMappable class " . get_class($source) . "\n" . $e->getMessage(), 0, $e);
            }
        };
        $mapping->setClosure($closure);
        $this->collection->add($mapping);
        return $this;
    }

    public function addNestedDirectMapping(string $attrName, string $sourceObjectClass, string $destinationObjectClass)
    {
        return $this->addNestedIndirectMapping($attrName, $attrName, $sourceObjectClass, $destinationObjectClass);
    }

    public function addNestedIndirectMapping(string $sourceAttr, string $destinationAttr, string $sourceObjectClass, string $destinationObjectClass)
    {
        $mapping = new Mapping();
        $sourceObj = new $sourceObjectClass();
        $destObj = new $destinationObjectClass();

        if (!$sourceObj instanceof IMappable && !$destObj instanceof IMappable) {
            throw new MappingException("Nested mapping requires that source or destination object classes implement the IMappable contract.");
        }
        $closure = function ($source, $target) use ($sourceAttr, $destinationAttr, $destObj) {
            try {
                if(is_array($source->$sourceAttr)){
                    // map all items of array to destObj
                    $array = [];
                    foreach($source->$sourceAttr as $sourceObj){
                        $mappedObj = Mapper::map($sourceObj, new $destObj());
                        $array[] = $mappedObj;
                    }
                    $target->$destinationAttr = $array;

                } else {
                    // only one destObj here
                    $mappedObj = Mapper::map($source->$sourceAttr, $destObj);
                    $target->$destinationAttr = $mappedObj;
                }
            } catch (Throwable $e) {
                throw new MappingException("There was an error during mapping of attribute '$sourceAttr'"
                    . "in IMappable class " . get_class($source) . "\n" . $e->getMessage(), 0, $e);
            }
        };
        $mapping->setClosure($closure);
        $this->collection->add($mapping);
        return $this;
    }

    public function addCustomMapping(Closure $closure)
    {
        $mapping = new Mapping();
        $mapping->setClosure($closure);
        $this->collection->add($mapping);
        return $this;
    }

    public function build(): MappingCollection
    {
        return $this->collection;
    }
}
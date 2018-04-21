<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


class DtoAttributeCollectionBuilder
{

    private $collection;

    private function __construct()
    {
        $this->collection = new DtoAttributeCollection();
    }

    public static function create(): self
    {
        return new self();
    }

    public function addPrimitive($name): self
    {
        $attr = new DtoAttribute($name);
        $this->collection->add($attr);
        return $this;
    }

    public function addComplex($name, $class): self
    {
        $attr = new DtoAttribute($name, DtoAttribute::TYPE_COMPLEX, $class);
        $this->collection->add($attr);
        return $this;
    }

    public function addComplexArray($name, $class): self
    {
        $attr = new DtoAttribute($name, DtoAttribute::TYPE_COMPLEX, $class, true);
        $this->collection->add($attr);
        return $this;
    }

    public function build(): DtoAttributeCollection
    {
        return $this->collection;
    }
}
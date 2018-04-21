<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


class DtoAttributeCollection
{

    /**
     * @var DtoAttribute[]
     */
    private $attributes = [];

    /**
     * @return DtoAttribute[]
     */
    public function all()
    {
        return $this->attributes;
    }

    /**
     * @param DtoAttribute $attr
     */
    public function add(DtoAttribute $attr): void
    {
        $this->attributes[] = $attr;
    }
}
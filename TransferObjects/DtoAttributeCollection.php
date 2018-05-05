<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;

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

    public function getAssocAttributeArray(IResolvableDto $dto)
    {
        $array = [];
        foreach ($this->attributes as $attribute) {
            $attrName = $attribute->getName();
            if (isset($dto->$attrName)) {
                $array[$attrName] = $dto->$attrName;
            } else{
                $array[$attrName] = null;
            }
        }
        return $array;
    }
}
<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;

class DtoResolver
{
    public static function fromArray(array $array, IResolvableDto $dto): IResolvableDto
    {
        $attrCol = $dto::getAttributeCollection();
        $attrs = $attrCol->all();

        foreach ($attrs as $attribute) {
            $item = self::findByKey($array, $attribute->getName());
            if (!is_null($item)) {
                self::resolveAttribute($attribute, $item, $dto);
            }
        }

        return $dto;
    }

    private static function findByKey($array, $name)
    {
        if (array_key_exists($name, $array)) {
            return ($array[$name]);
        }
        return null;
    }

    private static function resolveAttribute(DtoAttribute $attribute, $item, IResolvableDto $dto): void
    {
        if ($attribute->isComplex()) {
            self::resolveComplexAttribute($attribute, $item, $dto);
        } else {
            self::resolvePrimitiveAttribute($attribute, $item, $dto);
        }
    }

    private static function resolvePrimitiveAttribute(DtoAttribute $attribute, $item, IResolvableDto $dto): void
    {
        $attrName = $attribute->getName();
        $dto->$attrName = $item;
    }

    private static function resolveComplexAttribute(DtoAttribute $attribute, $item, IResolvableDto $dto): void
    {
        $attrName = $attribute->getName();

        if ($attribute->shouldParseObjectsFromArray()) {

            $innerArray = [];
            foreach ($item as $innerObj) {
                $innerArray[] = self::fromArray($innerObj, $attribute->getClassInstance());
            }
            $dto->$attrName = $innerArray;
        } else {
            $dto->$attrName = self::fromArray($item, $attribute->getClassInstance());
        }
    }
}
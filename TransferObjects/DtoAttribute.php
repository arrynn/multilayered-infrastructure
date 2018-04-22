<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Exceptions\DtoSettingException;

class DtoAttribute
{
    const TYPE_PRIMITIVE = 'attr_type_primitive';
    const TYPE_COMPLEX = 'attr_type_complex';

    private $name;
    private $type;
    /**
     * @var null|IResolvableDto
     */
    private $class;
    private $shouldParseObjectsFromArray;

    public function __construct($name, $type = self::TYPE_PRIMITIVE, $class = null, $shouldParseObjectsFromArray = false)
    {
        if ($type == self::TYPE_COMPLEX && !new $class() instanceof IResolvableDto) {
            throw new DtoSettingException("Complex DTO attributes must implement the IResolvableDto contract.");
        }

        $this->name = $name;
        $this->type = $type;
        $this->class = $class;
        $this->shouldParseObjectsFromArray = $shouldParseObjectsFromArray;
    }

    public function isComplex(): bool
    {
        return $this->type == self::TYPE_COMPLEX;
    }

    public function shouldParseObjectsFromArray(): bool
    {
        return $this->shouldParseObjectsFromArray;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getClassInstance(): IResolvableDto
    {
        return new $this->class();
    }
}
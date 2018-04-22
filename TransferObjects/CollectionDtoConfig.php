<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\TransferObjects;


use Arrynn\MultilayeredInfrastructure\TransferObjects\Contracts\IResolvableDto;
use Arrynn\MultilayeredInfrastructure\TransferObjects\Exceptions\DtoSettingException;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionDtoConfig
{
    private $sourceClass;
    private $destinationClass;

    private function __construct(string $sourceClass, string $destinationClass)
    {
        $this->sourceClass = $sourceClass;
        $this->destinationClass = $destinationClass;
    }

    public static function create(string $sourceClass, string $destinationClass): self
    {
        return new self($sourceClass, $destinationClass);
    }

    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }

    public function getDestinationClass(): string
    {
        return $this->destinationClass;
    }

    public function getSourceObj()
    {
        return new $this->sourceClass();
    }

    public function getDestinationObj()
    {
        return new $this->destinationClass();
    }
}
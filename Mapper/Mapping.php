<?php declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper;

use Arrynn\MultilayeredInfrastructure\Mapper\Contracts\IMapping;
use Closure;

class Mapping implements IMapping
{
    /**
     * @var Closure;
     */
    private $closure;

    public function getClosure(): Closure
    {
        return $this->closure;
    }

    public function setClosure(Closure $closure): void
    {
        $this->closure = $closure;
    }
}
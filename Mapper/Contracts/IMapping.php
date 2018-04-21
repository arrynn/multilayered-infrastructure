<?php
declare(strict_types=1);

namespace Arrynn\MultilayeredInfrastructure\Mapper\Contracts;


use Closure;

interface IMapping
{
    public function getClosure(): Closure;

    public function setClosure(Closure $closure): void;
}
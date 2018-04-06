<?php

namespace Arynn\MultilayeredInfrastructure\Console\Commands\Component;

use Illuminate\Console\GeneratorCommand;

class ComponentMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates component files';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        // TODO: Implement getStub() method.
    }
}

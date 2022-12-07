<?php

namespace KoalaFacade\DiamondConsole\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use KoalaFacade\DiamondConsole\Commands\Concerns\HasArguments;
use KoalaFacade\DiamondConsole\Commands\Concerns\HasOptions;
use KoalaFacade\DiamondConsole\Commands\Concerns\InteractsWithConsole;
use KoalaFacade\DiamondConsole\Contracts\Console;
use KoalaFacade\DiamondConsole\DataTransferObjects\PlaceholderData;
use KoalaFacade\DiamondConsole\Support\Source;

class ProviderMakeCommand extends Command implements Console
{
    use HasArguments, HasOptions, InteractsWithConsole;

    protected $signature = 'infrastructure:make:provider {name} {domain} {--force}';

    protected $description = 'Create a new service provider class';

    public function beforeCreate(): void
    {
        $this->info(string: 'Generating provider to your project.');
    }

    public function afterCreate(): void
    {
        $this->info(string: 'Successfully generate provider file.');
    }

    public function getNamespace(): string
    {
        return Source::resolveNamespace(
            structures: Source::resolveInfrastructurePath(),
            prefix: $this->resolveDomainArgument(),
            suffix: 'Providers',
        );
    }

    public function getStubPath(): string
    {
        return Source::resolveStubForPath(name: 'provider');
    }

    public function resolvePlaceholders(): PlaceholderData
    {
        return new PlaceholderData(
            namespace: $this->getNamespace(),
            class: $this->getClassName(),
        );
    }

    public function getClassName(): string
    {
        return Str::finish(Str::ucfirst($this->resolveNameArgument()), cap: 'ServiceProvider');
    }
}

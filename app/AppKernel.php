<?php
declare(strict_types=1);

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

final class AppKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        $bundles = require __DIR__ . '/bundles.php';

        foreach ($bundles as $bundle => $env) {
            if (isset($env['all'])) {
                yield new $bundle();
            }
        }
    }

    public function getCacheDir(): string
    {
        return dirname(__DIR__) . '/var/cache';
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__) . '/var/logs';
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $routes->import(__DIR__ . '/config/routing.yml');
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $this->injection($container);
        $this->configure($loader);
    }

    protected function injection(ContainerBuilder $container): void
    {
        // injection/{config}.php
        static $injections = [
            'autowire',
            'commandbus',
            'oauth',
            'storage',
        ];

        $inject = function ($injection) use ($container): void {
            (require __DIR__ . "/injection/{$injection}.php")($container);
        };

        array_map($inject, $injections);
    }

    protected function configure(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/{framework,twig}.yml', 'glob');
    }
}

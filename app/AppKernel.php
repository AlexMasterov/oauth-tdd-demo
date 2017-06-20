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

    public function registerBundles(): array
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
        ];
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

    protected function configureContainer(
        ContainerBuilder $container,
        LoaderInterface $loader
    ): void {
        $this->injection($container);
        $this->configure($loader);
    }

    protected function injection(ContainerBuilder $container): void
    {
        $injections = [
            require __DIR__ . '/injection/autowire.php',
            require __DIR__ . '/injection/commandbus.php',
            require __DIR__ . '/injection/oauth.php',
            require __DIR__ . '/injection/storage.php',
        ];

        $inject = function ($injection) use ($container): void {
            $injection($container);
        };

        array_map($inject, $injections);
    }

    protected function configure(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/framework.yml');
        $loader->load(__DIR__ . '/config/twig.yml');
    }
}

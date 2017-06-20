<?php
declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\{
    ContainerInterface,
    Definition,
    Loader\PhpFileLoader
};

return function (ContainerInterface $container): void {
    $projectDir = $container->getParameterBag()->get('kernel.project_dir');
    $loader = new PhpFileLoader($container, new FileLocator($projectDir));

    $autowired = (new Definition)->setAutowired(true);

    // Controllers
    $loader->registerClasses(
        $autowired,
        'Oauth\\Controller\\',
        'src/Controller/*'
    );

    // Domain
    $loader->registerClasses(
        $autowired,
        'Oauth\\Domain\\API\\',
        'src/Domain/API/*Handler*'
    );

    $loader->registerClasses(
        $autowired,
        'Oauth\\Domain\\Authorization\\',
        'src/Domain/Authorization/*Handler*'
    );
};

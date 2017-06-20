<?php
declare(strict_types=1);

use Oauth\Infrastructure\Storage\{
    SessionStorage,
    StorageInterface
};
use Symfony\Component\DependencyInjection\ContainerInterface;

return function (ContainerInterface $container): void {
    $container->autowire(SessionStorage::class);

    $container->setAlias(StorageInterface::class, SessionStorage::class);
};

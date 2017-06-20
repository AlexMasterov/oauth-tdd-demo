<?php
declare(strict_types=1);

use League\OAuth2\Client\Provider\Github;
use Symfony\Component\DependencyInjection\ContainerInterface;

return function (ContainerInterface $container): void {
    $options = [
        'clientId' => getenv('GITHUB_CLIENT_ID'),
        'clientSecret' => getenv('GITHUB_CLIENT_SECRET'),
    ];

    $container->register(Github::class)
        ->setShared(true)
        ->addArgument($options);
};

<?php

use Oauth\Infrastructure\CommandBus\{
    CommandBusInterface,
    TacticianCommandBus,
    TacticianCommandBusFactory,
    TacticianDynamicHandlerLocator
};
use League\Tactician\Handler\{
    CommandHandlerMiddleware,
    CommandNameExtractor\ClassNameExtractor,
    CommandNameExtractor\CommandNameExtractor,
    Locator\HandlerLocator,
    MethodNameInflector\HandleInflector,
    MethodNameInflector\MethodNameInflector
};
use League\Tactician\{
    CommandBus,
    Exception\MissingHandlerException
};
use Symfony\Component\DependencyInjection\{
    ContainerInterface,
    Reference
};

return function (ContainerInterface $container): void {
    $container->register(ClassNameExtractor::class);
    $container->register(HandleInflector::class);

    $container->setAlias(CommandNameExtractor::class, ClassNameExtractor::class);
    $container->setAlias(MethodNameInflector::class, HandleInflector::class);

    $container->autowire(CommandHandlerMiddleware::class);

    $container->autowire(TacticianDynamicHandlerLocator::class);
    $container->setAlias(HandlerLocator::class, TacticianDynamicHandlerLocator::class);

    $container->autowire(TacticianCommandBus::class);
    $container->setAlias(CommandBusInterface::class, TacticianCommandBus::class);

    $container->autowire(CommandBus::class)
        ->setShared(true)
        ->setFactory([TacticianCommandBusFactory::class, 'make']);
};

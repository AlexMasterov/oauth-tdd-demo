<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\CommandBus;

use League\Tactician\{
    Exception\MissingHandlerException,
    Handler\Locator\HandlerLocator
};
use Symfony\Component\DependencyInjection\ContainerInterface;

class TacticianDynamicHandlerLocator implements HandlerLocator
{
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getHandlerForCommand($commandName)
    {
        // FooCommand -> FooHandler
        $handler = preg_replace('/Command$/', 'Handler', $commandName);

        if (class_exists($handler)) {
            return $this->container->get($handler);
        }

        throw MissingHandlerException::forCommand($commandName);
    }

    /**
     * @var ContainerInterface
     */
    private $container;
}

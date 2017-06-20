<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\CommandBus;

use League\Tactician\{
    CommandBus,
    Handler\CommandHandlerMiddleware
};

final class TacticianCommandBusFactory
{
    public static function make(CommandHandlerMiddleware $handlerMiddleware)
    {
        return new CommandBus([$handlerMiddleware]);
    }
}

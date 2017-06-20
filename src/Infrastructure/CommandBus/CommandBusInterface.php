<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\CommandBus;

interface CommandBusInterface
{
    public function handle($command);
}

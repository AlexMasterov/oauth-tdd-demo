<?php
declare(strict_types=1);

namespace Oauth\Tests\Infrastructure;

use Oauth\Infrastructure\CommandBus\CommandBusInterface;

trait StubCommandBus
{
    protected function newCommandBus(array $commands = []): CommandBusInterface
    {
        return new class($commands) implements CommandBusInterface {
            public function __construct(array $commands = [])
            {
                $this->commands = $commands;
            }

            public function handle($command)
            {
                if (is_object($command)) {
                    $command = get_class($command);
                }

                return $this->commands[$command] ?? null;
            }

            /**
             * @var array
             */
            private $commands = [];
        };
    }
}

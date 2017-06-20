<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\CommandBus;

use League\Tactician\CommandBus;
use Oauth\Infrastructure\CommandBus\CommandBusInterface;

final class TacticianCommandBus implements CommandBusInterface
{
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function handle($command)
    {
        return $this->bus->handle($command);
    }

    /**
     * @var CommandBus
     */
    private $bus;
}

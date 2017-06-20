<?php
declare(strict_types=1);

namespace Oauth\Domain\Authorization;

final class LoginState
{
    public function __construct(string $url, string $state)
    {
        $this->url = $url;
        $this->state = $state;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function state(): string
    {
        return $this->state;
    }

    private $url;
    private $state;
}

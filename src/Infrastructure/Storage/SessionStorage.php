<?php
declare(strict_types=1);

namespace Oauth\Infrastructure\Storage;

use Oauth\Infrastructure\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionStorage implements StorageInterface
{
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function set(string $name, $value): void
    {
        $this->session->set($name, $value);
    }

    public function get(string $name, $default = null)
    {
        return $this->session->get($name, $default);
    }

    public function has(string $name): bool
    {
        return $this->session->has($name);
    }

    public function clear(): void
    {
        $this->session->clear();
    }

    /**
     * @var SessionInterface
     */
    private $session;
}

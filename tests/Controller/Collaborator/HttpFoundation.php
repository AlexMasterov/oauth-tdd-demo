<?php
declare(strict_types=1);

namespace Oauth\Tests\Controller\Collaborator;

use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

trait HttpFoundation
{
    protected function request(): string
    {
        return Request::class;
    }

    protected function response(): string
    {
        return Response::class;
    }

    protected function newRequest(...$args): Request
    {
        return new Request(...$args);
    }

    protected function newResponse(...$args): Response
    {
        return new Response(...$args);
    }
}

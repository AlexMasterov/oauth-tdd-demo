<?php
declare(strict_types=1);

namespace Oauth\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;

trait CanRedirect
{
    public function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }
}

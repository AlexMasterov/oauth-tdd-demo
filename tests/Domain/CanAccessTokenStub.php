<?php
declare(strict_types=1);

namespace Oauth\Tests\Domain;

use League\OAuth2\Client\Token\AccessToken;

trait CanAccessTokenStub
{
    protected function accessToken(...$args): AccessToken
    {
        $default = [
            ['access_token' => bin2hex(random_bytes(128))],
        ];

        $values = array_values(array_replace($default, $args));

        return new AccessToken(...$values);
    }
}

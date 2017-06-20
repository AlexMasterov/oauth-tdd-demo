<?php
declare(strict_types=1);

namespace Oauth\Domain\Authorization;

use League\OAuth2\Client\{
    Provider\Github,
    Token\AccessToken
};

class FetchTokenHandler
{
    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function handle(FetchTokenCommand $command): AccessToken
    {
        // https://github.com/thephpleague/oauth2-github#authorization-code-flow
        $params = [
            'code' => $command->code(),
            'state' => $command->state(),
        ];

        return $this->github->getAccessToken('authorization_code', $params);
    }

    /**
     * @var Github
     */
    private $github;
}

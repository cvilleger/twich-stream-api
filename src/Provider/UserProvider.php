<?php

namespace App\Provider;

use App\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProvider extends EntityUserProvider
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class, ['twitch' => 'email']);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): ?UserInterface
    {
        dd($response->getData());
        // TODO: Implement loadUserByOAuthUserResponse() method.
    }
}

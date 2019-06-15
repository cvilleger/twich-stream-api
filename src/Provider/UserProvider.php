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
        $email = $response->getEmail();
        if (null === $user = $this->findUser(['email' => $email])) {
            $user = new User();
            $user->setEmail($email);
            $user->setTwitterCreatedAt(new \DateTime($response->getData()['created_at']));
        }

        $user->setUsername($response->getRealName());
        $user->setProfilePicture($response->getProfilePicture());
        $user->setDisplayName($response->getNickname());
        $user->setEmailVerified($response->getData()['email_verified']);
        $user->setPartnered($response->getData()['partnered']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}

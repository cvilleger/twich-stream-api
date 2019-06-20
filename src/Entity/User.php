<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $email;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $emailVerified;

    /**
     * @var array
     *
     * @ORM\Column(type="simple_array")
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $displayName;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $profilePicture;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $partnered;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $twitterCreatedAt;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    protected $twitterId;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    public function setEmailVerified(bool $emailVerified): self
    {
        $this->emailVerified = $emailVerified;

        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function isPartnered(): bool
    {
        return $this->partnered;
    }

    public function setPartnered(bool $partnered): self
    {
        $this->partnered = $partnered;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTwitterCreatedAt(): \DateTime
    {
        return $this->twitterCreatedAt;
    }

    public function setTwitterCreatedAt(\DateTime $twitterCreatedAt): self
    {
        $this->twitterCreatedAt = $twitterCreatedAt;

        return $this;
    }

    public function getTwitterId(): string
    {
        return $this->twitterId;
    }

    public function setTwitterId(string $twitterId): self
    {
        $this->twitterId = $twitterId;
        return $this;
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\UserStateProcessor;
use App\State\UserStateProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_USER')",
            provider: UserStateProvider::class
        ),
        new Get(
            security: "is_granted('ROLE_USER')",
            provider: UserStateProvider::class
        ),
        new Post(
            security: "is_granted('ROLE_COMPANY_ADMIN') or is_granted('ROLE_SUPER_ADMIN')",
            processor: UserStateProcessor::class
        ),
        new Delete(
            security: "is_granted('ROLE_SUPER_ADMIN')"
        ),
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['ROLE_USER', 'ROLE_COMPANY_ADMIN', 'ROLE_SUPER_ADMIN'], message: 'Choose a valid role.')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100)]
    #[Assert\Regex(
        pattern: '/^(?=.*[A-Z])[A-Za-z ]+$/',
        message: 'Name must contain only letters and spaces with at least one uppercase letter'
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'users')]
    #[Assert\Expression(
        "this.getRole() === 'ROLE_SUPER_ADMIN' ? value === null : value !== null",
        message: "Company is required for users with ROLE_USER and ROLE_COMPANY_ADMIN, and forbidden for ROLE_SUPER_ADMIN"
    )]
    private ?Company $company = null;

    /**
     * @var Collection<int, ApiToken>
     */
    #[ORM\OneToMany(targetEntity: ApiToken::class, mappedBy: 'ownedBy')]
    private Collection $apiTokens;

    private ?array $accessTokenScopes = null;

    public function __construct()
    {
        $this->apiTokens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        if (null === $this->accessTokenScopes) {
            $roles = $this->roles;

        } else {
            $roles = $this->accessTokenScopes;
        }
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, ApiToken>
     */
    public function getApiTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): static
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens->add($apiToken);
            $apiToken->setOwnedBy($this);
        }

        return $this;
    }

    public function removeApiToken(ApiToken $apiToken): static
    {
        if ($this->apiTokens->removeElement($apiToken)) {
            // set the owning side to null (unless already changed)
            if ($apiToken->getOwnedBy() === $this) {
                $apiToken->setOwnedBy(null);
            }
        }

        return $this;
    }

    public function getValidTokenStrings(): array
    {
        return $this->getApiTokens()
            ->filter(fn(ApiToken $token) => $token->isValid())
            ->map(fn(ApiToken $token) => $token->getToken())
            ->toArray();

    }

    public function markAsTokenAuthenticated(array $scopes): void
    {
        $this->accessTokenScopes = $scopes;
    }
}

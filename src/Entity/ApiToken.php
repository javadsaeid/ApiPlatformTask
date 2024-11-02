<?php

namespace App\Entity;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Self_;

#[ORM\Entity(repositoryClass: ApiTokenRepository::class)]
class ApiToken
{
    private const PERSONAL_ACCESS_TOKEN = 'tcp_';
    public const SCOPE_USER = 'ROLE_USER';
    public const SCOPE_COMPANY_ADMIN = 'ROLE_COMPANY_ADMIN';
    public const SCOPE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public const SCOPES = [
        self::SCOPE_USER => 'Normal User',
        self::SCOPE_COMPANY_ADMIN => 'Company admin',
        self::SCOPE_SUPER_ADMIN => 'Super admin'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'apiTokens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ownedBy = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expiresAt = null;

    #[ORM\Column(length: 68)]
    private string $token;

    #[ORM\Column]
    private array $scopes = [];

    public function __construct(string $tokenType = self::PERSONAL_ACCESS_TOKEN)
    {
        $this->token = $tokenType.bin2hex(random_bytes(32));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwnedBy(): ?User
    {
        return $this->ownedBy;
    }

    public function setOwnedBy(?User $ownedBy): static
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }

    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeImmutable $expiresAt): static
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function setScopes(array $scopes): static
    {
        $this->scopes = $scopes;

        return $this;
    }
}

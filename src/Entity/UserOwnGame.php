<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use App\Repository\UserOwnGameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserOwnGameRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: [
            "groups" => [
                "owngame:item",
                // "owngame:collection",
            ]
        ]),
        // new GetCollection(normalizationContext: [
        //     "groups" => [
        //         "owngame:collection"
        //     ]
        // ]),
        // new Post(),
        // new Patch()
    ]
)]
class UserOwnGame
{
    #[Groups("owngame:item")]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("owngame:item")]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups("owngame:item")]
    #[ORM\Column]
    private ?int $gameTime = null;

    #[Groups("owngame:item")]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastUsedAt = null;

    #[Groups("owngame:item")]
    #[ORM\Column]
    private ?bool $isInstalled = null;

    #[Groups("owngame:item")]
    #[ORM\ManyToOne(inversedBy: 'ownedByUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    #[Groups("owngame:item")]
    #[ORM\ManyToOne(inversedBy: 'ownedGames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGameTime(): ?int
    {
        return $this->gameTime;
    }

    public function setGameTime(int $gameTime): static
    {
        $this->gameTime = $gameTime;

        return $this;
    }

    public function getLastUsedAt(): ?\DateTimeImmutable
    {
        return $this->lastUsedAt;
    }

    public function setLastUsedAt(?\DateTimeImmutable $lastUsedAt): static
    {
        $this->lastUsedAt = $lastUsedAt;

        return $this;
    }

    public function isInstalled(): ?bool
    {
        return $this->isInstalled;
    }

    public function setIsInstalled(bool $isInstalled): static
    {
        $this->isInstalled = $isInstalled;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}

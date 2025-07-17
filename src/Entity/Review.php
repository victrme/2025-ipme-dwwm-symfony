<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: [
            "groups" => [
                "review:item",
                "review:collection"
            ]
        ]),
        new GetCollection(normalizationContext: [
            "groups" => [
                "review:collection"
            ]
        ]),
        // new Post(),
        // new Patch()
    ]
)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("review:item")]
    private ?int $id = null;

    #[Groups("review:collection", "game:item")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups("review:collection", "game:item")]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups("review:collection", "game:item")]
    #[ORM\Column]
    private ?int $downVote = 0;

    #[Groups("review:collection", "game:item")]
    #[ORM\Column]
    private ?int $upVote = 0;

    #[Groups("review:collection", "game:item")]
    #[ORM\Column]
    private ?float $rating = null;

    #[Groups("review:item", "game:item")]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups("review:item", "game:item")]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[Groups("review:item")]
    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
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

    public function getDownVote(): ?int
    {
        return $this->downVote;
    }

    public function setDownVote(int $downVote): static
    {
        $this->downVote = $downVote;

        return $this;
    }

    public function getUpVote(): ?int
    {
        return $this->upVote;
    }

    public function setUpVote(int $upVote): static
    {
        $this->upVote = $upVote;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }
}

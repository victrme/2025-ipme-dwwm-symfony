<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: [
            "groups" => ["publisher:collection", "publisher:item"]
        ]),
        new GetCollection(normalizationContext: [
            "groups" => ["publisher:collection"]
        ]),
        new Post(
            normalizationContext: [
                "groups" => ["publisher:collection", "publisher:item"]
            ],
            denormalizationContext: [
                "groups" => ["publisher:post"]
            ]
        ),
        new Patch(
            normalizationContext: [
                "groups" => ["publisher:collection", "publisher:item"]
            ],
            denormalizationContext: [
                "groups" => ["publisher:post"]
            ]
        )
    ]
)]
class Publisher
{
    #[Groups(["publisher:item", "game:post"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("publisher:item")]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(["publisher:collection", "publisher:post", "game:item"])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups("publisher:collection", "publisher:post", "game:item")]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[Groups(["publisher:item", "publisher:post", "game:item"])]
    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[Groups(["publisher:item", "publisher:post"])]
    #[ORM\ManyToOne(inversedBy: 'publishers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'publisher')]
    private Collection $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): static
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setPublisher($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getPublisher() === $this) {
                $game->setPublisher(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 2)]
	private ?string $code = null;

	#[ORM\Column(length: 255)]
	private ?string $name = null;

	#[ORM\Column(length: 255)]
	private ?string $nationality = null;

	#[ORM\Column(length: 255)]
	private ?string $slug = null;

	#[ORM\Column(length: 255)]
	private ?string $urlFlag = null;

	/**
	 * @var Collection<int, Publisher>
	 */
	#[ORM\OneToMany(targetEntity: Publisher::class, mappedBy: 'country')]
	private Collection $publishers;

	/**
	 * @var Collection<int, User>
	 */
	#[ORM\OneToMany(targetEntity: User::class, mappedBy: 'country')]
	private Collection $users;

	/**
	 * @var Collection<int, Game>
	 */
	#[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'countries')]
	private Collection $games;

	public function __construct()
	{
		$this->publishers = new ArrayCollection();
		$this->users = new ArrayCollection();
		$this->games = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCode(): ?string
	{
		return $this->code;
	}

	public function setCode(string $code): static
	{
		$this->code = $code;

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

	public function getNationality(): ?string
	{
		return $this->nationality;
	}

	public function setNationality(string $nationality): static
	{
		$this->nationality = $nationality;

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

	public function getUrlFlag(): ?string
	{
		return $this->urlFlag;
	}

	public function setUrlFlag(string $urlFlag): static
	{
		$this->urlFlag = $urlFlag;

		return $this;
	}

	/**
	 * @return Collection<int, Publisher>
	 */
	public function getPublishers(): Collection
	{
		return $this->publishers;
	}

	public function addPublisher(Publisher $publisher): static
	{
		if (!$this->publishers->contains($publisher)) {
			$this->publishers->add($publisher);
			$publisher->setCountry($this);
		}

		return $this;
	}

	public function removePublisher(Publisher $publisher): static
	{
		if ($this->publishers->removeElement($publisher)) {
			// set the owning side to null (unless already changed)
			if ($publisher->getCountry() === $this) {
				$publisher->setCountry(null);
			}
		}

		return $this;
	}

	/**
	 * @return Collection<int, User>
	 */
	public function getUsers(): Collection
	{
		return $this->users;
	}

	public function addUser(User $user): static
	{
		if (!$this->users->contains($user)) {
			$this->users->add($user);
			$user->setCountry($this);
		}

		return $this;
	}

	public function removeUser(User $user): static
	{
		if ($this->users->removeElement($user)) {
			// set the owning side to null (unless already changed)
			if ($user->getCountry() === $this) {
				$user->setCountry(null);
			}
		}

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
			$game->addCountry($this);
		}

		return $this;
	}

	public function removeGame(Game $game): static
	{
		if ($this->games->removeElement($game)) {
			$game->removeCountry($this);
		}

		return $this;
	}
}

<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, mappedBy="players")
     */
    private $gamesAsPlayer;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="owner")
     */
    private $gamesAsOwner;

    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->gamesAsPlayer = new ArrayCollection();
        $this->gamesAsOwner = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsPlayer(): Collection
    {
        return $this->gamesAsPlayer;
    }

    public function addGamesAsPlayer(Game $gamesAsPlayer): self
    {
        if (!$this->gamesAsPlayer->contains($gamesAsPlayer)) {
            $this->gamesAsPlayer[] = $gamesAsPlayer;
            $gamesAsPlayer->addPlayer($this);
        }

        return $this;
    }

    public function removeGamesAsPlayer(Game $gamesAsPlayer): self
    {
        if ($this->gamesAsPlayer->removeElement($gamesAsPlayer)) {
            $gamesAsPlayer->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsOwner(): Collection
    {
        return $this->gamesAsOwner;
    }

    public function addGamesAsOwner(Game $gamesAsOwner): self
    {
        if (!$this->gamesAsOwner->contains($gamesAsOwner)) {
            $this->gamesAsOwner[] = $gamesAsOwner;
            $gamesAsOwner->setOwner($this);
        }

        return $this;
    }

    public function removeGamesAsOwner(Game $gamesAsOwner): self
    {
        if ($this->gamesAsOwner->removeElement($gamesAsOwner)) {
            // set the owning side to null (unless already changed)
            if ($gamesAsOwner->getOwner() === $this) {
                $gamesAsOwner->setOwner(null);
            }
        }

        return $this;
    }
}

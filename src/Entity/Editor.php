<?php

namespace App\Entity;

use App\Repository\EditorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditorRepository::class)]
class Editor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 80)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'editor', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'constructeur', targetEntity: Support::class)]
    private Collection $supports;

    #[ORM\OneToOne(cascade: ['persist', 'remove'], orphanRemoval:true)]
    private ?Image $mainImage = null;

    private bool $deleteMainImage;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->supports = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setEditor($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getEditor() === $this) {
                $game->setEditor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Support>
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->supports->contains($support)) {
            $this->supports->add($support);
            $support->setConstructeur($this);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        if ($this->supports->removeElement($support)) {
            // set the owning side to null (unless already changed)
            if ($support->getConstructeur() === $this) {
                $support->setConstructeur(null);
            }
        }

        return $this;
    }

    public function getMainImage(): ?Image
    {
        return $this->mainImage;
    }

    public function setMainImage(?Image $mainImage): self
    {
        if ($mainImage !== null && $mainImage->getPath() !== null) {
            $this->mainImage = $mainImage;
        }

        return $this;
    }
    
    /**
     * Get the value of deleteMainImage
     */ 
    public function getDeleteMainImage(): bool
    {
        return $this->deleteMainImage ?? false;
    }

    /**
     * Set the value of deleteMainImage
     *
     * @return  self
     */ 
    public function setDeleteMainImage(bool $deleteMainImage): self
    {
        $this->deleteMainImage = $deleteMainImage;

        if ($this->deleteMainImage) {
            $this->mainImage = null;
        }

        return $this;
    }
}
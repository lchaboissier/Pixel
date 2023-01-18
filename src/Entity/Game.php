<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
// use Doctrine\ORM\Mapping\JoinColumn;
// use Doctrine\ORM\Mapping\JoinColumns;
// use Doctrine\ORM\Query\AST\Join;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game 
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 120)]
    #[Assert\NotBlank()]
    private string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column]
    private bool $enabled = false;

    /*
    Annotation pour PHP < 8
    @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="games")
    */
    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(onDelete: "SET NULL")]
    private ?Editor $editor = null;

    #[ORM\Column]
    private \DateTime $dateSortie;

    // orphanRemoval: Supprimer automatiquement l'image si elle n'a plus de lien avec le jeu
    #[ORM\OneToOne(cascade: ['persist', 'remove'], orphanRemoval:true)]
    private ?Image $mainImage = null;

    private bool $deleteMainImage;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[Ignore]
    private ?User $author = null;

    #[ORM\ManyToMany(targetEntity: Support::class, inversedBy: 'games')]
    private Collection $support;

    public function __construct()
    {
        $this->support = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title ?? ''; // $this->title != null ? $this->title : ''
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = strip_tags($description, ['div', 'p', 'strong', 'a']);

        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getDateSortie(): \DateTime
    {
        return $this->dateSortie;
    }

    public function setDateSortie($dateSortie): self
    {
        $this->dateSortie = $dateSortie;

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

    public function getAuthor(): ?user
    {
        return $this->author;
    }

    public function setAuthor(?user $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Support>
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->support->contains($support)) {
            $this->support->add($support);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        $this->support->removeElement($support);

        return $this;
    }
}
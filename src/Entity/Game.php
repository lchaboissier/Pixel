<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\GameRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Query\AST\Join;

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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Image $mainImage = null;

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
        $this->mainImage = $mainImage;

        return $this;
    }
}
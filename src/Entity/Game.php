<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
<<<<<<< HEAD
use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
=======
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5

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
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Editor $editor = null;

<<<<<<< HEAD
=======
    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=120)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var null|string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;


    /**
     * Get the value of id
     *
     * @return  int
     */ 
>>>>>>> 44d67d710b70d073ebd1a02239dc4f8f02c8eea5
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

    public function __toString()
    {
        return $this->editor;
    }
}
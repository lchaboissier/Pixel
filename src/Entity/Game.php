<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Game
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=120)
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
}
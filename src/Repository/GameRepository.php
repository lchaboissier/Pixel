<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findData(int $itemCount = 20, int $page = 1, string $search = ''): Paginator
    {
        $begin = ($page - 1) * $itemCount; // Calcul de l'offset

        $qb = $this->createQueryBuilder('g')
            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($begin)
        ;

        if ($search !== "") { // S'il y a une requête
            $qb->where("g.title LIKE :search") // Ici ":search" est une variable définie juste après
                ->setParameter(':search', "%$search%")
            ;
            }

        // ENvoie la requête générée dans l'objet Paginator
        return new Paginator($qb->getQuery());
    }
}
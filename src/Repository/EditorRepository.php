<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Editor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Editor>
 *
 * @method Editor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Editor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Editor[]    findAll()
 * @method Editor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EditorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Editor::class);
    }

    public function save(Editor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Editor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findData(int $itemCount = 20, int $page = 1, string $search = '', User $author = null): Paginator
    {
        $begin = ($page - 1) * $itemCount; // Calcul de l'offset

        $qb = $this->createQueryBuilder('g')
            ->setMaxResults($itemCount) // LIMIT
            ->setFirstResult($begin)
        ;

        if ($search !== "") { // S'il y a une recherche
            $qb->where("g.title LIKE :search") // Ici ":search" est un paramètre défini juste après
                ->setParameter(':search', "%$search%")
            ;
        }

        if ($author !== null) {
            $qb->andWhere('g.author = :author')
                ->setParameter(':author', $author)
            ;
        }

        // Envoie la requête générée dans l'objet Paginator
        return new Paginator($qb->getQuery());
    }

//    /**
//     * @return Editor[] Returns an array of Editor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Editor
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
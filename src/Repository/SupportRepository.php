<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Support;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Support>
 *
 * @method Support|null find($id, $lockMode = null, $lockVersion = null)
 * @method Support|null findOneBy(array $criteria, array $orderBy = null)
 * @method Support[]    findAll()
 * @method Support[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Support::class);
    }

    public function save(Support $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Support $entity, bool $flush = false): void
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
//     * @return Support[] Returns an array of Support objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Support
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

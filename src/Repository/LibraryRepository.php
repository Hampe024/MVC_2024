<?php

namespace App\Repository;

use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Library>
 */
class LibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }

    public function findOneByISBN($isbn): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM Library AS l
            WHERE l.ISBN = :isbn
        ';

        $resultSet = $conn->executeQuery($sql, ['isbn' => $isbn]);

        $res = $resultSet->fetchAssociative();

        if (gettype($res) === "array") {
            return $res;
        };
        return [];
    }

    public function doCreate(
        string $title,
        string $isbn,
        string $author,
        string $imgURL
    ): int {
        $entityManager = $this->getEntityManager();
    
        $book = new Library();
        $book->setTitle($title);
        $book->setISBN($isbn);
        $book->setAuthor($author);
        $book->setImgURL($imgURL);
    
        $entityManager->persist($book);
        $entityManager->flush();
    
        return $book->getId();
    }

    public function doDelete(int $id): void {
        $entityManager = $this->getEntityManager();
        $book = $entityManager->getRepository(Library::class)->find($id);
    
        if ($book !== null) {
            $entityManager->remove($book);
            $entityManager->flush();
        }
    }

    public function doUpdate(
        int $id,
        string $title,
        string $isbn,
        string $author,
        string $imgURL
    ): int {
        $entityManager = $this->getEntityManager();
        $book = $entityManager->getRepository(Library::class)->find($id);
    
        $book->setTitle($title);
        $book->setISBN($isbn);
        $book->setAuthor($author);
        $book->setImgURL($imgURL);

        $entityManager->flush();

        return $book->getId();

    }

    //    /**
    //     * @return Library[] Returns an array of Library objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Library
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

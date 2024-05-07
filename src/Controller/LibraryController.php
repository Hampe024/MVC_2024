<?php

namespace App\Controller;

use App\Entity\Library;
use Biblys\Isbn\Isbn;
use Biblys\Isbn\IsbnValidationException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function library(): Response
    {
        return $this->render('library/home.html.twig');
    }

    #[Route('/library/create', name: 'library_create')]
    public function createProduct(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Library();
        $book->setTitle("This is a third book");
        $book->setISBN("978054792822");
        $book->setAuthor("J. R. R. Tolkien");
        $book->setImgURL("theHobbit.png");

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }

    #[Route('/library/show', name: 'libraryShowAll')]
    public function showAllLibrary(
        LibraryRepository $libraryRepository
    ): Response {
        $books = $libraryRepository->findAll();

        $hasValidEan13 = array();
        $bookLinks = array();

        foreach ($books as $book) {
            try {
                Isbn::validateAsEAN13($book->getISBN());
                $hasValidEan13[] = true;
            } catch (IsbnValidationException) {
                $hasValidEan13[] = false;
            }
            $bookLinks[] = [
                "see" => "",
                "delete" => "",
                "update" => ""
            ];
        }
        $data = [
            'books' => $books,
            'hasValidEan13' => $hasValidEan13
        ];
        return $this->render('library/showAll.html.twig', $data);
        // $response = $this->json($libraryRepository->findAll());
        // $response->setEncodingOptions(
        //     $response->getEncodingOptions() | JSON_PRETTY_PRINT
        // );
        // return $response;
    }

    #[Route('/library/show/{id}', name: 'library_by_id')]
    public function showLibraryById(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        return $this->render('library/showOne.html.twig', ["book" => $libraryRepository->find($id)]);
    }
}

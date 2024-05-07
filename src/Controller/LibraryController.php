<?php

namespace App\Controller;

use App\Entity\Library;
use Biblys\Isbn\Isbn;
use Biblys\Isbn\IsbnValidationException;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function library(): Response
    {
        return $this->render('library/home.html.twig');
    }

    #[Route('/library/prepCreate', name: 'libraryPrepCreate')]
    public function libraryPrepCreate(
    ): Response {
        return $this->render('library/prepCreate.html.twig');
    }

    #[Route('/library/create', name: 'libraryDoCreate', methods: ['POST'])]
    public function libraryDoCreate(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Library();
        $book->setTitle($request->request->get("title"));
        $book->setISBN($request->request->get("isbn"));
        $book->setAuthor($request->request->get("author"));
        $book->setImgURL($request->request->get("imgURL"));

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('libraryShowAll');
    }

    #[Route('/library/show', name: 'libraryShowAll')]
    public function showAllLibrary(
        LibraryRepository $libraryRepository
    ): Response {
        $books = $libraryRepository->findAll();

        $hasValidEan13 = array();

        foreach ($books as $book) {
            try {
                Isbn::validateAsEAN13($book->getISBN());
                $hasValidEan13[] = true;
            } catch (IsbnValidationException) {
                $hasValidEan13[] = false;
            }
        }
        $data = [
            'books' => $books,
            'hasValidEan13' => $hasValidEan13
        ];
        return $this->render('library/showAll.html.twig', $data);
    }

    #[Route('/library/show/json', name: 'libraryShowAllJSON')]
    public function showAllLibraryJSON(
        LibraryRepository $libraryRepository
    ): Response {
        $response = $this->json($libraryRepository->findAll());
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route('/library/show/{id}', name: 'libraryById')]
    public function showLibraryById(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        $book = $libraryRepository->find($id);
        $hasValidEan13;

        try {
            Isbn::validateAsEAN13($book->getISBN());
            $hasValidEan13 = true;
        } catch (IsbnValidationException) {
            $hasValidEan13 = false;
        }
        $data = [
            "book" => $book,
            "hasValidEan13" => $hasValidEan13
        ];

        return $this->render('library/showOne.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'libraryDeleteById', methods: ['POST'])]
    public function deleteLibraryById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('libraryShowAll');
    }

    #[Route('/library/prepUpdate/{id}', name: 'libraryPrepUpdateById', methods: ['POST'])]
    public function libraryPrepUpdateById(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        return $this->render('library/prepUpdate.html.twig', ["book" => $libraryRepository->find($id)]);
    }

    #[Route('/library/update/{id}', name: 'libraryDoUpdateById', methods: ['POST'])]
    public function libraryDoUpdateById(
        Request $request,
        ManagerRegistry $doctrine,
        int $id,
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setTitle($request->request->get("title"));
        $book->setISBN($request->request->get("isbn"));
        $book->setAuthor($request->request->get("author"));
        $book->setImgURL($request->request->get("imgURL"));

        $entityManager->flush();

        return $this->redirectToRoute('libraryShowAll');
    }
}

<?php

namespace App\Controller;

use Biblys\Isbn\Isbn;
use Biblys\Isbn\IsbnValidationException;
use Biblys\Isbn\IsbnParsingException;
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
        LibraryRepository $libraryRepository
    ): Response {

        $id = $libraryRepository->doCreate(
            $request->request->get("title"),
            $request->request->get("isbn"),
            $request->request->get("author"),
            $request->request->get("imgURL")
        );

        $this->addFlash(
            'notice',
            'Book with id ' . $id . ' was added!'
        );

        return $this->redirectToRoute('libraryShowAll');
    }

    #[Route('/library/show', name: 'libraryShowAll')]
    public function showAllLibrary(
        LibraryRepository $libraryRepository,
        Isbn $isbnTester
    ): Response {
        $books = $libraryRepository->findAll();

        $hasValidEan13 = array();

        foreach ($books as $book) {
            try {
                $isbnTester->validateAsEAN13($book->getISBN());
                $hasValidEan13[] = true;
            } catch (IsbnValidationException) {
                $hasValidEan13[] = false;
            } catch (IsbnParsingException) {
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
        Isbn $isbnTester,
        int $id
    ): Response {
        $book = $libraryRepository->find($id);
        $hasValidEan13 = false;

        try {
            $isbnTester->validateAsEAN13($book->getISBN());
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
        LibraryRepository $libraryRepository,
        int $id
    ): Response {

        $libraryRepository->doDelete($id);

        $this->addFlash(
            'notice',
            'Book with id ' . $id . ' was deleted!'
        );

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
        LibraryRepository $libraryRepository,
        int $id,
    ): Response {

        $libraryRepository->doUpdate(
            $id,
            $request->request->get("title"),
            $request->request->get("isbn"),
            $request->request->get("author"),
            $request->request->get("imgURL")
        );

        $this->addFlash(
            'notice',
            'Book with id ' . $id . ' was updated!'
        );

        return $this->redirectToRoute('libraryShowAll');
    }
}

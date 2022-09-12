<?php

/**
 * Book controller.
 */

namespace App\Controller;

use App\Entity\Book;
use App\Form\Type\BookType;
use App\Service\BookServiceInterface;
use App\Service\CatalogServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class BookController.
 */
#[Route('/book')]
class BookController extends AbstractController
{
    /**
     * Book service.
     */
    private BookServiceInterface $bookService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Catalog Service.
     */
    private CatalogServiceInterface $catalogService;

    /**
     * Constructor.
     *
     * @param BookServiceInterface    $bookService    Book service
     * @param TranslatorInterface     $translator     Translator
     * @param CatalogServiceInterface $catalogService CatalogService
     */
    public function __construct(BookServiceInterface $bookService, TranslatorInterface $translator, CatalogServiceInterface $catalogService)
    {
        $this->bookService = $bookService;
        $this->translator = $translator;
        $this->catalogService = $catalogService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'book_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $pagination = $this->bookService->getPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        return $this->render('book/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Book $book Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'book_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', ['book' => $book]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'book_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(
            BookType::class,
            $book,
            ['action' => $this->generateUrl('book_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->save($book);

            $this->addFlash(
                'success',
                $this->translator->trans('created successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'book_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(
            BookType::class,
            $book,
            [
                'method' => 'GET',
                'action' => $this->generateUrl('book_edit', ['id' => $book->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->bookService->save($book);

            $this->addFlash(
                'success',
                $this->translator->trans('edited successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/edit.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Book    $book    Book entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'book_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Book $book): Response
    {
        $form = $this->createForm(
            FormType::class,
            $book,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('book_delete', ['id' => $book->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bookService->delete($book);

            $this->addFlash(
                'success',
                $this->translator->trans('deleted successfully')
            );

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/delete.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{catalog_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['catalog_id'] = $request->query->getInt('filters_catalog_id');

        return $filters;
    }
}

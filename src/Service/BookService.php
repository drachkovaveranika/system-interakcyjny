<?php

/**
 * Book service.
 */

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BookService.
 */
class BookService implements BookServiceInterface
{
    /**
     * Catalog service.
     */
    private CatalogServiceInterface $catalogService;

    /**
     * Book repository.
     */
    private BookRepository $bookRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param BookRepository          $bookRepository Book repository
     * @param PaginatorInterface      $paginator      Paginator
     * @param CatalogServiceInterface $catalogService Catalog service
     */
    public function __construct(BookRepository $bookRepository, PaginatorInterface $paginator, CatalogServiceInterface $catalogService)
    {
        $this->bookRepository = $bookRepository;
        $this->paginator = $paginator;
        $this->catalogService = $catalogService;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     *
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bookRepository->queryAll($filters),
            $page,
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     */
    public function save(Book $book): void
    {
        $this->bookRepository->save($book);
    }

    /**
     * Delete entity.
     *
     * @param Book $book Book entity
     */
    public function delete(Book $book): void
    {
        $this->bookRepository->delete($book);
    }

    /**
     * Find by id.
     *
     * @param int $id Book id
     *
     * @return Book|null Book entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Book
    {
        return $this->bookRepository->findOneById($id);
    }

    /**
     * Prepare filters for the books list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['catalog_id'])) {
            $catalog = $this->catalogService->findOneById($filters['catalog_id']);
            if (null !== $catalog) {
                $resultFilters['catalog'] = $catalog;
            }
        }

        return $resultFilters;
    }
}

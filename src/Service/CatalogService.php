<?php
/**
 * Catalog service.
 */

namespace App\Service;

use App\Entity\Catalog;
use App\Repository\CatalogRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class CatalogService.
 */
class CatalogService implements CatalogServiceInterface
{
    /**
     * Catalog repository.
     */
    private CatalogRepository $catalogRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CatalogRepository  $catalogRepository Catalog repository
     * @param PaginatorInterface $paginator         Paginator
     */
    public function __construct(CatalogRepository $catalogRepository, PaginatorInterface $paginator)
    {
        $this->catalogRepository = $catalogRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->catalogRepository->queryAll(),
            $page,
            CatalogRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Catalog $catalog Catalog entity
     */
    public function save(Catalog $catalog): void
    {
        $this->catalogRepository->save($catalog);
    }

    /**
     * Delete entity.
     *
     * @param Catalog $catalog Book entity
     */
    public function delete(Catalog $catalog): void
    {
        $this->catalogRepository->delete($catalog);
    }
}

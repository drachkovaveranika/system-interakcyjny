<?php
/**
 * Catalog service interface.
 */

namespace App\Service;

use App\Entity\Catalog;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface CatalogServiceInterface.
 */
interface CatalogServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Catalog $catalog Catalog entity
     */
    public function save(Catalog $catalog): void;

    /**
     * Delete entity.
     *
     * @param Catalog $catalog Catalog entity
     */
    public function delete(Catalog $catalog): void;
}

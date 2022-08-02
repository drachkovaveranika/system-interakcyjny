<?php

/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Catalog;

/**
 * Class CategoryFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class CatalogFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'catalogs', function (int $i) {
            $catalog = new Catalog();
            $catalog->setName($this->faker->unique()->word);

            return $catalog;
        });

        $this->manager->flush();
    }
}

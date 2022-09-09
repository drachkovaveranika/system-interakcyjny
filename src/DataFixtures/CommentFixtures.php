<?php

/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(100, 'comments', function (int $i) {
            $comment = new Comment();
            $comment->setContext($this->faker->text);
            /** @var Book $book */
            $book = $this->getRandomReference('books');
            $comment->setBook($book);
            $comment->setNick($this->faker->word);
            $comment->setEmail($this->faker->email);

            return $comment;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array {0: CatalogFixtures::class}
     */
    public function getDependencies(): array
    {
        return [BookFixtures::class];
    }
}

<?php

/*
 * Book Entity.
 */

namespace App\Entity;

use App\Repository\BookRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Book.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Title.
     */
    #[ORM\Column(type: 'string', length: 45)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 64)]
    private ?string $title = null;

    /**
     * Author.
     */
    #[ORM\Column(type: 'string', length: 45)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 5, max: 64)]
    private ?string $author = null;

    /**
     * Catalog.
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Catalog",
     *     inversedBy="books",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinTable(name="books_catalogs")
     */
    #[ORM\ManyToOne(targetEntity: Catalog::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Catalog $catalog = null;

    /**
     * CreatedAt.
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string|null $title Title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Author.
     *
     * @return string|null Author
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * Setter for Author.
     *
     * @param string|null $author Author
     */
    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for Catalog.
     *
     * @return Catalog|null Catalog
     */
    public function getCatalog(): ?Catalog
    {
        return $this->catalog;
    }

    /**
     * Setter for Catalog.
     *
     * @param Catalog|null $catalog Catalog
     */
    public function setCatalog(?Catalog $catalog): void
    {
        $this->catalog = $catalog;
    }

    /**
     * Getter for created at.
     *
     * @return DateTimeImmutable|null Created at
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     *
     * @param DateTimeImmutable|null $createdAt Created at
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

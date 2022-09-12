<?php

/*
 * Comment Entity.
 */

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Context.
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    private ?string $context = null;

    /**
     * Book.
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Book",
     *     inversedBy="comments",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinTable(name="comments_books")
     */
    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Book $book = null;

    /**
     * Nick.
     */
    #[ORM\Column(length: 15)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 64)]
    private ?string $nick = null;

    /**
     * Email.
     */
    #[ORM\Column(type: 'string', length: 45)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 64)]
    private ?string $email = null;

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
     * Getter for Context.
     *
     * @return string|null Context
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * Setter for Context.
     *
     * @param string|null $context Context
     */
    public function setContext(?string $context): void
    {
        $this->context = $context;
    }

    /**
     * Getter for Book.
     *
     * @return Book|null Book
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * Setter for Book.
     *
     * @param Book|null $book Book
     */
    public function setBook(?Book $book): void
    {
        $this->book = $book;
    }

    /**
     * Getter for Nick.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for Nick.
     *
     * @param string $nick Nick
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }

    /**
     * Getter for Email.
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Email.
     *
     * @param string $email Email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}

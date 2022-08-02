<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Context.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $context = null;

    /**
     * Volume.
     *
     * @var Book|null
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Book",
     *     inversedBy="comments",
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinTable(name="comments_books")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\Collection")
     */
    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $volume = null;

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

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Getter for Volume.
     *
     * @return Book|null Volume
     */
    public function getVolume(): ?Book
    {
        return $this->volume;
    }

    /**
     * Setter for Volume.
     *
     * @param Book|null $volume Volume
     */
    public function setVolume(?Book $volume): void
    {
        $this->volume = $volume;
    }
}

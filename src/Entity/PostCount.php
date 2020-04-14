<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostCountRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"post_date"}
 * )})
 */
class PostCount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $postDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $postCount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostDate(): ?DateTimeInterface
    {
        return $this->postDate;
    }

    public function setPostDate(DateTimeInterface $postDate): self
    {
        $this->postDate = $postDate;

        return $this;
    }

    public function getPostCount(): ?int
    {
        return $this->postCount;
    }

    public function setPostCount(int $postCount): self
    {
        $this->postCount = $postCount;

        return $this;
    }

    public function incrementPostCount(): void
    {
        $this->postCount++;
    }
}

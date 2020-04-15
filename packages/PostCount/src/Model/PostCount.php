<?php

namespace Acme\PostCount\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"post_date"}
 * )})
 */
class PostCount
{
    /**
     * @var int
     *
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

    public function __construct(\DateTime $postDate, int $postCount = 1)
    {
        $this->postDate = $postDate;
        $this->postCount = $postCount;
    }

    public function countUp(): void
    {
        ++$this->postCount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostDate(): \DateTime
    {
        return $this->postDate;
    }

    public function getPostCount(): int
    {
        return $this->postCount;
    }
}

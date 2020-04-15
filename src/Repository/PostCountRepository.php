<?php

namespace App\Repository;

use Acme\PostCount\Model\Exception\PostCountNotFoundException;
use Acme\PostCount\Model\PostCount;
use Acme\PostCount\Model\PostCountRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class PostCountRepository implements PostCountRepositoryInterface
{
    /**
     * @var DoctrinePostCountRepository
     */
    private $doctrineRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(DoctrinePostCountRepository $doctrineRepository, EntityManagerInterface $entityManager)
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->entityManager = $entityManager;
    }

    public function add(PostCount $postCount): void
    {
        $this->entityManager->persist($postCount);
        $this->entityManager->flush($postCount);
    }

    public function update(PostCount $postCount): void
    {
        $this->entityManager->flush($postCount);
    }

    public function find(\DateTime $dateTime): PostCount
    {
        $postCount = $this->doctrineRepository->findOneBy(['postDate' => $dateTime]);
        if ($postCount instanceof PostCount) {
            return $postCount;
        }
        throw new PostCountNotFoundException('entity not found');
    }
}

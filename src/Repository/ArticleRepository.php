<?php

namespace App\Repository;

use Acme\Article\Model\Article;
use Acme\Article\Model\ArticleRepositoryInterface;
use Acme\Article\Model\Exception\ArticleNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @var DoctrineArticleRepository
     */
    private $doctrineRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(DoctrineArticleRepository $doctrineRepository, EntityManagerInterface $entityManager)
    {
        $this->doctrineRepository = $doctrineRepository;
        $this->entityManager = $entityManager;
    }

    public function add(Article $article): void
    {
        $this->entityManager->persist($article);
        $this->entityManager->flush($article);
    }

    public function update(Article $article): void
    {
        $this->entityManager->flush($article);
    }

    public function find(int $id): Article
    {
        $article = $this->doctrineRepository->find($id);
        if ($article instanceof Article) {
            return $article;
        }

        throw new ArticleNotFoundException("${$id} not found");
    }
}

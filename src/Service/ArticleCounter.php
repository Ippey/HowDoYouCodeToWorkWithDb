<?php

namespace App\Service;

use App\Entity\Article;
use App\Model\ArticleCounterInterface;
use App\Model\ArticleInterface;
use App\Model\PostCountFinderInterface;
use Doctrine\ORM\EntityManagerInterface;

class ArticleCounter implements ArticleCounterInterface
{
    /**
     * @var PostCountFinderInterface
     */
    private $postCountFinder;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param PostCountFinderInterface $postCountFinder
     * @param EntityManagerInterface $em
     */
    public function __construct(PostCountFinderInterface $postCountFinder, EntityManagerInterface $em)
    {
        $this->postCountFinder = $postCountFinder;
        $this->em = $em;
    }

    public function count(ArticleInterface $article): void
    {
        /** @var Article $article */
        $postCount = $this->postCountFinder->findOneByPostDateOrCreate($article->getCreatedAt());
        $postCount->countUp();

        $this->em->persist($postCount);
        $this->em->flush();
    }

}

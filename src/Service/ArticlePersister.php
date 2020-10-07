<?php

namespace App\Service;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Model\ArticleInterface;
use App\Model\ArticlePersisterInterface;
use App\Model\PostedArticleInterface;
use Doctrine\ORM\EntityManagerInterface;

class ArticlePersister implements ArticlePersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function persist(PostedArticleInterface $postedArticle, ArticleInterface $saveArticle): ArticleInterface
    {
        /** @var PostedArticle $postedArticle */
        /** @var Article $saveArticle */
        $saveArticle
            ->setName($postedArticle->getName())
            ->setBody($postedArticle->getBody())
        ;

        $this->em->persist($saveArticle);
        $this->em->flush();

        return $saveArticle;
    }

}

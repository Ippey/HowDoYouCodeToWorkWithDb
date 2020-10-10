<?php

namespace App\Service\UseCase\Article;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Model\ArticleCounterInterface;
use App\Model\ArticlePersisterInterface;
use App\Service\UseCase\Article\Exception\RegisterException;

class RegisterUseCase
{
    /**
     * @var ArticlePersisterInterface
     */
    private $articlePersister;

    /**
     * @var ArticleCounterInterface
     */
    private $articleCounter;

    /**
     * @param ArticlePersisterInterface $articlePersister
     * @param ArticleCounterInterface $articleCounter
     */
    public function __construct(ArticlePersisterInterface $articlePersister, ArticleCounterInterface $articleCounter)
    {
        $this->articlePersister = $articlePersister;
        $this->articleCounter = $articleCounter;
    }

    /**
     * @param PostedArticle $postedArticle
     * @throws RegisterException
     */
    public function register(PostedArticle $postedArticle): void
    {
        try {
            $savedArticle = $this->articlePersister->persist($postedArticle, new Article());
        } catch (\Exception $e) {
            throw new RegisterException($e->getMessage(), $e->getCode(), $e);
        }

        $this->articleCounter->count($savedArticle);
    }
}

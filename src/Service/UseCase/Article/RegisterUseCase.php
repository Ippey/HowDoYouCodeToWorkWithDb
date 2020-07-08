<?php

namespace App\Service\UseCase\Article;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Model\ArticlePersisterInterface;
use App\Service\UseCase\Article\Exception\RegisterException;

class RegisterUseCase
{
    /**
     * @var ArticlePersisterInterface
     */
    private $articlePersister;

    /**
     * @param ArticlePersisterInterface $articlePersister
     */
    public function __construct(ArticlePersisterInterface $articlePersister)
    {
        $this->articlePersister = $articlePersister;
    }

    /**
     * @param PostedArticle $postedArticle
     * @throws RegisterException
     */
    public function register(PostedArticle $postedArticle): void
    {
        try {
            $this->articlePersister->persist($postedArticle, new Article());
        } catch (\Exception $e) {
            throw new RegisterException($e->getMessage(), '', $e);
        }
    }
}

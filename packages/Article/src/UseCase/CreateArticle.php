<?php

namespace Acme\Article\UseCase;

use Acme\Article\Model\ArticleCreatedEvent;
use Acme\Article\Model\ArticleFactory;
use Acme\Article\Model\ArticleRepositoryInterface;
use Acme\Component\TransactionManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class CreateArticle
{
    /**
     * @var ArticleFactory
     */
    private $factory;

    /**
     * @var ArticleRepositoryInterface
     */
    private $repository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var TransactionManagerInterface
     */
    private $transactionManager;

    public function __construct(ArticleFactory $factory, ArticleRepositoryInterface $repository, EventDispatcherInterface $eventDispatcher, TransactionManagerInterface $transactionManager)
    {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
        $this->transactionManager = $transactionManager;
    }

    public function __invoke(string $name, string $body)
    {
        $this->transactionManager->begin();
        try {
            $article = $this->factory->newArticle($name, $body);
            $this->repository->add($article);
            $this->eventDispatcher->dispatch(new ArticleCreatedEvent($article));
            $this->transactionManager->commit();
        } catch (\Throwable $e) {
            $this->transactionManager->rollback();
            throw $e;
        }
    }
}

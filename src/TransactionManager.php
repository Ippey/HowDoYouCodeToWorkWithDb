<?php

namespace App;


use Acme\Component\TransactionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class TransactionManager implements TransactionManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function begin(): void
    {
        $this->entityManager->beginTransaction();
    }

    public function commit(): void
    {
        $this->entityManager->commit();;
    }

    public function rollback(): void
    {
        $this->entityManager->rollback();
    }

}

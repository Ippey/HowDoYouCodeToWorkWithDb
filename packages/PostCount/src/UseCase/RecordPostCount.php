<?php

namespace Acme\PostCount\UseCase;

use Acme\PostCount\Model\Exception\PostCountNotFoundException;
use Acme\PostCount\Model\PostCount;
use Acme\PostCount\Model\PostCountRepositoryInterface;

final class RecordPostCount
{
    /**
     * @var PostCountRepositoryInterface
     */
    private $repository;

    public function __construct(PostCountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(\DateTime $now): void
    {
        try {
            $postData = $this->repository->find($now);
            $postData->countUp();
            $this->repository->update($postData);
        } catch (PostCountNotFoundException $e) {
            $postCount = new PostCount($now);
            $this->repository->add($postCount);
        }
    }
}

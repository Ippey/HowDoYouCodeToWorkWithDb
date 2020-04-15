<?php

namespace Acme\PostCount\Model;

use Acme\PostCount\Model\Exception\PostCountNotFoundException;

interface PostCountRepositoryInterface
{
    public function add(PostCount $postCount): void;

    public function update(PostCount $postCount): void;

    /**
     * @throws PostCountNotFoundException
     */
    public function find(\DateTime $dateTime): PostCount;
}

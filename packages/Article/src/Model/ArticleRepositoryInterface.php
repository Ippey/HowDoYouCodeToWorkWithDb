<?php

namespace Acme\Article\Model;

use Acme\Article\Model\Exception\ArticleNotFoundException;

interface ArticleRepositoryInterface
{
    public function add(Article $article): void;

    public function update(Article $article): void;

    /**
     * @throws ArticleNotFoundException
     */
    public function find(int $id): Article;
}

<?php

namespace App\Model;

interface ArticleCounterInterface
{
    public function count(ArticleInterface $article): void;
}

<?php

namespace App\Model;

interface ArticlePersisterInterface
{
    public function persist(PostedArticleInterface $postedArticle, ArticleInterface $saveArticle): ArticleInterface;
}

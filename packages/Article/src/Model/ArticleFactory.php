<?php

namespace Acme\Article\Model;

class ArticleFactory
{
    public function newArticle(string $name, string $body): Article
    {
        // なにかあれば、このへんでバリデーションとかするかも
        return new Article($name, $body);
    }
}

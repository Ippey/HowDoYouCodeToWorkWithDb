<?php

namespace Acme\Article\Model;

use Symfony\Contracts\EventDispatcher\Event;

class ArticleCreatedEvent extends Event
{
    /**
     * @var Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function getArticle(): array
    {
        return [
            'id' => $this->article->getId(),
            'name' => $this->article->getName(),
            'body' => $this->article->getBody(),
        ];
    }
}

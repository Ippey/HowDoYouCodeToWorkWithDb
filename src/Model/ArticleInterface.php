<?php

namespace App\Model;

interface ArticleInterface
{
    public function setName(string $name): self;

    public function setBody(string $body): self;

    public function getCreatedAt(): ?\DateTimeInterface;
}

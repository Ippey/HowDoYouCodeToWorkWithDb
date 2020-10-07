<?php

namespace App\Model;

interface PostedArticleInterface
{
    public function getName(): ?string;

    public function getBody(): ?string;
}

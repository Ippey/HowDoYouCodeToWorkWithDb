<?php

namespace App\DTO\Request;

use App\Model\PostedArticleInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PostedArticle implements PostedArticleInterface
{
    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var string|null
     * @Assert\Length(max=1000)
     */
    private $body;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return PostedArticle
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     * @return PostedArticle
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}

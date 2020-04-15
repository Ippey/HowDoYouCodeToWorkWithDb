<?php

namespace App\Controller\Articles;

use App\Repository\DoctrineArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles", name="articles")
 * Class ListController
 */
class ListController
{
    /**
     * @var DoctrineArticleRepository
     */
    private $doctrineArticleRepository;

    public function __construct(DoctrineArticleRepository $doctrineArticleRepository)
    {
        $this->doctrineArticleRepository = $doctrineArticleRepository;
    }

    /**
     * @Template("articles/index.html.twig")
     */
    public function __invoke(): array
    {
        $articles = $this->doctrineArticleRepository->findAll();

        return [
            'articles' => $articles,
        ];
    }
}

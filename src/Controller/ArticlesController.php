<?php

namespace App\Controller;

use Acme\Article\UseCase\CreateArticle;
use App\Form\ArticleType;
use App\Repository\DoctrineArticleRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @var DoctrineArticleRepository
     */
    private $doctrineArticleRepository;

    /**
     * @var CreateArticle
     */
    private $createArticle;

    public function __construct(DoctrineArticleRepository $doctrineArticleRepository, CreateArticle $createArticle)
    {
        $this->doctrineArticleRepository = $doctrineArticleRepository;
        $this->createArticle = $createArticle;
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function index(): Response
    {
        $articles = $this->doctrineArticleRepository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles/new", name="articles_new")
     */
    public function new(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ($this->createArticle)($form->getData()['name'], $form->getData()['body']);
            $this->addFlash('success', '登録しました');

            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

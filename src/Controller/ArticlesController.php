<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ArticlesController extends AbstractController
{
    /** @var ArticleService  */
    private $articleService;

    /**
     * ArticlesController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function index()
    {
        $articles = $this->articleService->getList();
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles/new", name="articles_new")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Throwable
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $this->articleService->add($article);

            $this->addFlash('success', '登録しました');
            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PostCount;
use App\Form\ArticleType;
use App\Repository\PostCountRepository;
use App\Service\UseCase\Article\RegisterUseCase;
use DateTime;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @var RegisterUseCase
     */
    private $registerUseCase;

    /**
     * @param RegisterUseCase $registerUseCase
     */
    public function __construct(RegisterUseCase $registerUseCase)
    {
        $this->registerUseCase = $registerUseCase;
    }

    /**
     * @Route("/articles", name="articles")
     * @Template()
     * @return array
     */
    public function index()
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepository->findAll();

        return [
            'articles' => $articles,
        ];
    }

    /**
     * @Route("/articles/new", name="articles_new")
     * @Template
     * @param Request $request
     * @return RedirectResponse|array
     * @throws Exception
     */
    public function new(Request $request)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $this->registerUseCase->register($article);

            $this->addFlash('success', '登録しました');
            return $this->redirectToRoute('articles');
        }

        return [
            'form' => $form->createView(),
        ];
    }
}

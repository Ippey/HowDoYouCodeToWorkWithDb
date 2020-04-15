<?php

namespace App\Controller\Articles;

use Acme\Article\UseCase\CreateArticle;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles/new", name="articles_new")
 */
class NewController extends AbstractController
{
    /**
     * @var CreateArticle
     */
    private $createArticle;

    public function __construct(CreateArticle $createArticle)
    {
        $this->createArticle = $createArticle;
    }

    public function __invoke(Request $request): Response
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

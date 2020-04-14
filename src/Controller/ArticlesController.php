<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PostCount;
use App\Form\ArticleType;
use App\Repository\PostCountRepository;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index()
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepository->findAll();
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/articles/new", name="articles_new")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            /** @var PostCountRepository $postCountRepository */
            $postCountRepository = $this->getDoctrine()->getRepository(PostCount::class);
            $postCount = $postCountRepository->findOneBy([
                'postDate' => new DateTime(),
            ]);
            if (empty($postCount)) {
                $postCount = new PostCount();
                $postCount->setPostDate(new DateTime());
                $entityManager->persist($postCount);
            }
            $postCount->setPostCount($postCount->getPostCount() + 1);
            $entityManager->flush();

            $this->addFlash('success', '登録しました');
            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PostCount;
use App\Form\ArticleType;
use App\Repository\PostCountRepository;
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

        return [
            'form' => $form->createView(),
        ];
    }
}

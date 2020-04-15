<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PostCount;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\PostCountRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles", name="articles_")
 */
class ArticlesController extends AbstractController
{
    /**
     * @var ArticleRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ArticleRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $articles = $this->repository->findAll();

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, PostCountRepository $postCountRepository)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($article);

            $postCount = $postCountRepository->findOneBy([
                'postDate' => new DateTime(),
            ]);

            if (empty($postCount)) {
                $postCount = new PostCount();
                $postCount->setPostDate(new DateTime());
                $this->em->persist($postCount);
            }

            $postCount->setPostCount($postCount->getPostCount() + 1);
            $this->em->flush();

            $this->addFlash('success', '登録しました');

            return $this->redirectToRoute('articles_index');
        }

        return $this->render('articles/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

<?php


namespace App\Service;


use App\Entity\Article;
use App\Entity\PostCount;
use App\Repository\ArticleRepository;
use App\Repository\PostCountRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Throwable;

class ArticleService
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var ArticleRepository  */
    private $articleRepository;
    /** @var PostCountRepository  */
    private $postCountRepository;

    /**
     * ArticleService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ArticleRepository $articleRepository
     * @param PostCountRepository $postCountRepository
     */
    public function __construct(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, PostCountRepository $postCountRepository)
    {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->postCountRepository = $postCountRepository;
    }

    /**
     * @return Article[]
     */
    public function getList()
    {
        return $this->articleRepository->findAll();
    }

    /**
     * @param Article $article
     * @throws Throwable
     */
    public function add(Article $article)
    {
        $this->entityManager->transactional(function () use ($article) {
            $this->articleRepository->add($article);
            $today = new DateTime();
            $postCount = $this->getPostCountOrCreate($today);
            $postCount->incrementPostCount();
        });
    }

    /**
     * @param DateTime $dateTime
     * @return PostCount|null
     * @throws ORMException
     */
    private function getPostCountOrCreate(DateTime $dateTime)
    {
        $postCount = $this->postCountRepository->findOneBy([
            'postDate' => $dateTime,
        ]);
        if (empty($postCount)) {
            $postCount = new PostCount();
            $postCount->setPostDate($dateTime);
            $this->postCountRepository->add($postCount);
        }

        return $postCount;
    }
}
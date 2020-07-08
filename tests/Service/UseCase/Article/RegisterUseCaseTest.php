<?php

namespace App\Tests\Service\UseCase\Article;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Model\ArticlePersisterInterface;
use App\Service\UseCase\Article\RegisterUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class RegisterUseCaseTest extends TestCase
{
    /**
     * @var ArticlePersisterInterface|ObjectProphecy
     */
    private $articlePersisterP;

    protected function setUp(): void
    {
        $this->articlePersisterP = $this->prophesize(ArticlePersisterInterface::class);
    }

    public function test()
    {
        $postedArticle = $this->prophesize(PostedArticle::class)->reveal();

        $this->articlePersisterP->persist($postedArticle, new Article())->willReturnArgument(1)->shouldBeCalled();

        $this->getSUT()->register($postedArticle);
    }

    private function getSUT(): RegisterUseCase
    {
        return new RegisterUseCase($this->articlePersisterP->reveal());
    }
}

<?php

namespace App\Tests\Service\UseCase\Article;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Model\ArticleCounterInterface;
use App\Model\ArticlePersisterInterface;
use App\Service\UseCase\Article\Exception\RegisterException;
use App\Service\UseCase\Article\RegisterUseCase;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class RegisterUseCaseTest extends TestCase
{
    /**
     * @var ArticlePersisterInterface|ObjectProphecy
     */
    private $articlePersisterP;

    /**
     * @var ArticleCounterInterface|ObjectProphecy
     */
    private $articleCounterP;

    protected function setUp(): void
    {
        $this->articlePersisterP = $this->prophesize(ArticlePersisterInterface::class);
        $this->articleCounterP = $this->prophesize(ArticleCounterInterface::class);
    }

    protected function tearDown(): void
    {
        $this->articlePersisterP = null;
        $this->articleCounterP = null;
    }

    public function test()
    {
        $postedArticle = $this->prophesize(PostedArticle::class)->reveal();

        $this->articlePersisterP->persist($postedArticle, new Article())->willReturnArgument(1)->shouldBeCalled();
        $this->articleCounterP->count(Argument::type(Article::class))->shouldBeCalled();

        $this->getSUT()->register($postedArticle);
    }

    public function test_保存でエラーが出たらcountは更新しない()
    {
        $this->expectException(RegisterException::class);

        $postedArticle = $this->prophesize(PostedArticle::class)->reveal();
        $this->articlePersisterP->persist($postedArticle, new Article())->willThrow( new \Exception('dummy-error'))->shouldBeCalled();
        $this->articleCounterP->count(Argument::any())->shouldNotBeCalled();

        $this->getSUT()->register($postedArticle);
    }

    private function getSUT(): RegisterUseCase
    {
        return new RegisterUseCase(
            $this->articlePersisterP->reveal(),
            $this->articleCounterP->reveal()
        );
    }
}

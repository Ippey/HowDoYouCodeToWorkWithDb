<?php

namespace App\Tests\Service;

use App\Model\ArticleInterface;
use App\Model\PostCountFinderInterface;
use App\Model\PostCountInterface;
use App\Service\ArticleCounter;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ArticleCounterTest extends TestCase
{
    public function test()
    {
        $createdAt = new \DateTimeImmutable('2020-09-01');
        $articleP = $this->prophesize(ArticleInterface::class);
        $articleP->getCreatedAt()->willReturn($createdAt)->shouldBeCalled();
        $article = $articleP->reveal();

        $postCountP = $this->prophesize(PostCountInterface::class);
        $postCountP->countUp()->shouldBeCalled();
        $postCount = $postCountP->reveal();

        $finderP = $this->prophesize(PostCountFinderInterface::class);
        $emP = $this->prophesize(EntityManagerInterface::class);

        $finderP->findOneByPostDateOrCreate($createdAt)->willReturn($postCount)->shouldBeCalled();
        $emP->persist($postCount)->shouldBeCalled();
        $emP->flush()->shouldBeCalled();

        $SUT = new ArticleCounter(
            $finderP->reveal(),
            $emP->reveal()
        );
        $SUT->count($article);
    }
}

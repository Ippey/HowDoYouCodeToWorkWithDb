<?php

namespace App\Tests\Service;

use App\DTO\Request\PostedArticle;
use App\Entity\Article;
use App\Service\ArticlePersister;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ArticlePersisterTest extends TestCase
{
    private $emP;

    protected function setUp(): void
    {
        $this->emP = $this->prophesize(EntityManagerInterface::class);
    }

    public function test()
    {
        $dto = new PostedArticle();
        $dto
            ->setName($name = 'dummy-name')
            ->setBody($body = 'dummy-body')
        ;
        $ormEntity = new Article();

        $this->emP->persist($ormEntity)->shouldBeCalled();
        $this->emP->flush()->shouldBeCalled();

        $returned = $this->getSUT()->persist($dto, $ormEntity);
        $this->assertSame($ormEntity, $returned);
        $this->assertEquals($name, $returned->getName());
        $this->assertEquals($body, $returned->getBody());
    }

    private function getSUT(): ArticlePersister
    {
        return new ArticlePersister(
            $this->emP->reveal()
        );
    }
}

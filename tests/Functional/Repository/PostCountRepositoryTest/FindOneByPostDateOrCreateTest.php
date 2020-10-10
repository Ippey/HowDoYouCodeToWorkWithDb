<?php

namespace App\Tests\Functional\Repository\PostCountRepositoryTest;

use App\Entity\PostCount;
use App\Repository\PostCountRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FindOneByPostDateOrCreateTest extends KernelTestCase
{
    use FixturesTrait;

    protected function setUp(): void
    {
        $this->loadFixtureFiles([
            __DIR__.'/../../../../var/fixtures/Repository/PostCountRepository/find_one_by_post_date_or_create.yaml',
        ]);
        static::ensureKernelShutdown();
    }

    public function test_既存PostCountがある場合()
    {
        $actual = $this->getSUT()->findOneByPostDateOrCreate(new \DateTimeImmutable('2020-09-01'));
        $this->assertEquals(1, $actual->getPostCount(), '保存されているエンティティが出てきている');
    }

    public function test_既存PostCountがない場合()
    {
        $actual = $this->getSUT()->findOneByPostDateOrCreate(new \DateTimeImmutable('2020-09-02'));
        $this->assertNull($actual->getId());
        $this->assertNotNull($actual->getPostDate(), '日付はセット済');
        $this->assertEquals(null, $actual->getPostCount(), 'newされたばかりなのでnull');
    }

    private function getSUT(): PostCountRepository
    {
        static::bootKernel();

        return self::$kernel->getContainer()->get('doctrine')->getManager()->getRepository(PostCount::class);
    }
}

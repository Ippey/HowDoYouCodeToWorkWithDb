<?php

namespace App\Tests\Controller\Articles;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexTest extends WebTestCase
{
    use FixturesTrait;

    public function test()
    {
        $client = static::createClient();
        $this->loadFixtureFiles([
            __DIR__.'/../../../var/fixtures/Controller/Articles/index.yaml',
        ]);

        $crawler = $client->request('GET', '/articles');

        $response = $client->getResponse();
        $this->assertTrue($response->isOk(), $response->getStatusCode());

        $this->assertCount(2, $crawler->filter('table tbody tr'));
    }
}

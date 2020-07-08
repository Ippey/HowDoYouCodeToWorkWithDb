<?php

namespace App\Tests\Controller\Articles;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewTest extends WebTestCase
{
    use FixturesTrait;

    public function test()
    {
        $client = static::createClient();
        $this->loadFixtureFiles([]);

        $crawler = $client->request('GET', '/articles/new');
        $form = $crawler->selectButton('投稿する')->form();

        $form['article[name]'] = 'test-name';
        $form['article[body]'] = 'test-body';
        $client->submit($form);

        $response = $client->getResponse();
        $this->assertTrue($response->isRedirect('/articles'), $response->headers->get('Location'));
    }
}

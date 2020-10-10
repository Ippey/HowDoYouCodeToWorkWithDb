<?php

namespace App\Tests\Form;

use App\DTO\Request\PostedArticle;
use App\Form\ArticleType;
use Symfony\Component\Form\Test\TypeTestCase;

class ArticleTypeTest extends TypeTestCase
{
    public function test_submit()
    {
        $form = $this->factory->create(ArticleType::class);
        $form->submit([
            'name' => 'aaa',
            'body' => 'bbb',
        ]);

        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isValid());
        $this->assertInstanceOf(PostedArticle::class, $form->getData());
    }
}

<?php

namespace App\Model;

interface PostCountFinderInterface
{
    public function findOneByPostDateOrCreate(\DateTimeInterface $postDate): PostCountInterface;
}

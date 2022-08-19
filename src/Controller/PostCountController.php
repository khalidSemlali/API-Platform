<?php

namespace App\Controller;

use App\Repository\PostRepository;


class PostCountController
{

    /**
     * @var PostRepository
     */

    public function __construct(private PostRepository $postRepository) 
    {

    }

    public function __invoke(): int
    {
        return $this->postRepository->count([]);
    }
}
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Repository\PostRepository;


class PostCountController
{

    /**
     * @var PostRepository
     */

    public function __construct(private PostRepository $postRepository) 
    {

    }

    public function __invoke(Request $request): int
    {
        dd($request->get('online'));
        return $this->postRepository->count([]);
    }
}
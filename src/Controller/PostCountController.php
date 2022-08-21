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
        $onlineQuery = $request->get('online');
        $conditions = [];
        if($onlineQuery != null) {
            $conditions = ['online' => $onlineQuery == '1' ? true : false];
        }
        return $this->postRepository->count([]);
    }
}
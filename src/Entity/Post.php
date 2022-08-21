<?php

namespace App\Entity;

use App\Controller\PostPublishController;
use App\Controller\PostCountController;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  
use Symfony\Component\Validator\Constraints\Length;  
use Symfony\Component\Validator\Constraints\Valid;  
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['read:collection'], 'openapi_definition_name' => 'Collection'],
    denormalizationContext: ['groups' => ['put:Post']],
    paginationItemsPerPage: 2,
    paginationMaximumItemsPerPage: 2,
    paginationClientItemsPerPage:true,
    collectionOperations: [
        'get',      
        'post',
        'count' => [
            'method' => 'GET',
            'path' => 'posts/count',
            'controller' => PostCountController::class,
            'read' => false,    
            'pagination_enabled' => false,
            'filters' => [],
            'openapi_context' => [
                'summary' => 'Recupere le nombre total darticle',
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'online',
                        'schema' => [
                            'type' => 'integer',
                            'maximum' => 1,
                            'minimum' => 0
                        ],
                        'description' => 'filtre les articles'
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'ok',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'integer',
                                    'example' => 3  
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    itemOperations: [
        'put',
        'delete',
        'get' => [
            'normalization_content' => ['groups' => ['read:collection', 'read:item', 'read:Post'], 
            'openapi_definition_name' => 'Detail']
        ],
        'publish' => [
            'method' => 'POST',
            'path' => '/posts/{id}/publish',
            'controller' => PostPublishController::class,
            'openapi_context' => [
                'summary' => 'permet de publier un article',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => []
                        ]
                    ]
                ]
            ]
        ]   
    ]
        ),
        ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'title' => 'partial'])]


class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'put:Post']),
    Length(min:5, groups: ['create:Post'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'put:Post'])]  
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:item', 'put:Post'])]  
    private ?string $content = null;


    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Groups(['read:item', 'put:Post'])]  
    private ?Category $category = null;

    #[ORM\Column(type:"boolean", options: ["default: 0"])]
    #[Groups(['read:collection']),
    ApiProperty(openapiContext: ['type' => 'boolean', 'description' => 'en ligne ou pas ?'])]  
    private ?bool $online = false;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}

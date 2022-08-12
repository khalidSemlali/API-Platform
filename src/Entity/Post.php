<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;    


#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource (
    normalizationContext: ['groups' => ['read:collection']],
    denormalizationContext: ['groups' => ['put:Post']],
    itemOperations: [
        'put',
        'delete',
        'get' => [
            'normalization_content' => ['groups' => ['read:collection', 'read:item', 'read:Post']]
        ]
    ]
)]


class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'put:Post'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'put:Post'])]  
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:item', 'put:Post'])]  
    private ?string $content = null;

    #[ORM\Column]
    #[Groups(['read:item'])]  
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Groups(['read:item', 'put:Post'])]  
    private ?Category $category = null;

    public function __construct (){
        $this->createdAt = new \DateTime(); 
        $this->updated = new \DateTime();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Ramsey\Uuid\uuid;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Serializer\Annotation\Groups;  


#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'delete', 'put' => [
        'denormalization_context' => [
            'groups' => ['put:Dependency']
        ]
    ]],
    paginationEnabled: false
)]
class Dependency
{
    #[ApiProperty(
        identifier: true
    )]

    private string $uuid;
    #[ApiProperty(
        description: 'Nom de la dependence'
    ),
    Length(min:2), NotBlank()
    ]

    private string $name;
    #[ApiProperty(
            description: 'Nom de la dependence',
            openapiContext: [
                'example' => "6.1.*"
            ]
        ), Length(min:2), NotBlank(), Groups(['put:dependency'])
    ]
    private string $version;

    public function __construct(
     string $name,
     string $version,
    ){
        $this->uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
        $this->name = $name;
        $this->version = $version;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }


}

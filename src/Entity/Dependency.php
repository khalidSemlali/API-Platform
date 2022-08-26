<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get'],
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
    )]

    private string $name;
    #[ApiProperty(
        description: 'Nom de la dependence',
        openapiContext: [
            'example' => "6.1.*"
        ]
    )]
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


}

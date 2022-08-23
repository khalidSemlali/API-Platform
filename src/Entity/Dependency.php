<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations: ['get'],
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
    string $uuid,
     string $name,
     string $version,
    ){
        $this->uuid = $uuid;
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

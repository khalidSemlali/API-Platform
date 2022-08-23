<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictionDataProviderInterface;
use App\Entity\Dependency;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface,
RestrictionDataProviderInterface
{
    public function __construct(private string $rootPath) {}

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        $items = [];
        foreach($json['require'] as $name => $version) {
            $items[] = new Dependency('aze', $name, $version);
        }
        return $items;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Dependency::class;
    }

    
}

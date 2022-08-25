<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Dependency;
use Ramsey\Uuid\Uuid;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface,
RestrictionDataProviderInterface, ItemDataProviderInterface
{
    public function __construct(private string $rootPath) {}

    private function getDependencies(): array
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        return $json['require'];
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        $items = [];
        foreach($json['require'] as $name => $version) {
            $items[] = new Dependency(Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString(), $name, $version);
        }
        return $items;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Dependency::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        //
    }

    
}

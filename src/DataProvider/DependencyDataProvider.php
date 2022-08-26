<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictionDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;
use Ramsey\Uuid\Uuid;

class DependencyDataProvider implements ContextAwareCollectionDataProviderInterface,
RestrictionDataProviderInterface, ItemDataProviderInterface
{

    public function __construct(private DependencyRepository $repository) {}

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass == Dependency::class;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->repository->find($id);
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        return $this->repository->findAll();
    }

    
}

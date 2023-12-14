<?php

declare(strict_types=1);

namespace App\Controller\Admin\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\BooleanFilterType;

class IsAdminFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel('Est administrateur')
            ->setFormType(BooleanFilterType::class);
    }

    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        if (true === $filterDataDto->getValue()) {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->like("{$filterDataDto->getEntityAlias()}.{$filterDataDto->getProperty()}", ':role')
            )
                ->setParameter('role', '%ROLE_ADMIN%');
        }
    }
}

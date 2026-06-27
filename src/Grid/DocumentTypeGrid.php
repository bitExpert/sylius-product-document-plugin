<?php

/*
 * This file is part of the Sylius Product Document package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace BitExpert\SyliusProductDocumentPlugin\Grid;

use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentType;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Component\Grid\Attribute\AsGrid;

#[AsGrid(
    name: 'bitexpert_product_document_document_type',
    resourceClass: DocumentType::class,
)]
final class DocumentTypeGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->orderBy('position', 'asc')
            ->addField(
                StringField::create('code')
                    ->setLabel('sylius.ui.code')
                    ->setSortable(true),
            )
            ->addField(
                StringField::create('name')
                    ->setLabel('sylius.ui.name')
                    ->setSortable(true, 'translation.name'),
            )
            ->addField(
                TwigField::create('position', '@BitExpertSyliusProductDocumentPlugin/Admin/Grid/Field/document_type_position.html.twig')
                    ->setLabel('sylius.ui.position')
                    ->setPath('.'),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                    Action::create('update_positions', 'update_document_type_positions'),
                ),
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    UpdateAction::create(),
                    DeleteAction::create(),
                ),
            )
            ->addFilter(
                StringFilter::create('search', ['translation.name'])
                    ->setLabel('sylius.ui.search'),
            );
    }

    public static function getName(): string
    {
        return 'bitexpert_product_document_document_type';
    }

    public function getResourceClass(): string
    {
        return DocumentType::class;
    }
}

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

namespace BitExpert\SyliusProductDocumentPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $catalog = $menu->getChild('catalog');

        $this->addChild($catalog ?? $menu->getFirstChild());
    }

    private function addChild(ItemInterface $item): void
    {
        $item
            ->addChild('bitexpert_document_type', [
                'route' => 'bitexpert_product_document_admin_document_type_index',
            ])
            ->setLabel('bitexpert_product_document.menu.admin.catalog.document_types')
            ->setLabelAttribute('icon', 'file alternate outline');
    }
}

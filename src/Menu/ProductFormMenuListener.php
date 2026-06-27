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

use Sylius\Bundle\AdminBundle\Event\ProductMenuBuilderEvent;

final class ProductFormMenuListener
{
    public function addItems(ProductMenuBuilderEvent $event): void
    {
        $event->getMenu()
            ->addChild('documents')
            ->setAttribute('template', '@BitExpertSyliusProductDocumentPlugin/Admin/Product/Tab/_document.html.twig')
            ->setLabel('bitexpert_product_document.ui.documents');
    }
}

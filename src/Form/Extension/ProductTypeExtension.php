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

namespace BitExpert\SyliusProductDocumentPlugin\Form\Extension;

use BitExpert\SyliusProductDocumentPlugin\Form\Type\ProductDocumentType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('productDocuments', LiveCollectionType::class, [
            'entry_type' => ProductDocumentType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label' => false,
            'button_add_options' => [
                'label' => 'bitexpert_product_document.ui.add_document',
                'attr' => ['class' => 'btn btn-outline-primary'],
            ],
            'button_delete_options' => [
                'label' => false,
                'attr' => ['class' => 'btn btn-outline-danger btn-sm'],
            ],
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}

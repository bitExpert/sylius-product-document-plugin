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

namespace BitExpert\SyliusProductDocumentPlugin\Form\Type;

use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentType;
use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentVisibility;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductDocumentType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentType', EntityType::class, [
                'label' => false,
                'class' => DocumentType::class,
                'choice_label' => 'name',
            ])
            ->add('file', FileType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('documentVisibility', EnumType::class, [
                'class' => DocumentVisibility::class,
                'choices' => DocumentVisibility::getChoices(),
                'label' => false,
                'required' => true,
            ]);
    }

    public function getBlockPrefix(): string
    {
        return 'bitexpert_product_document';
    }
}

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

namespace BitExpert\SyliusProductDocumentPlugin\DependencyInjection;

use BitExpert\SyliusProductDocumentPlugin\Controller\DocumentTypeController;
use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentType;
use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentTypeTranslation;
use BitExpert\SyliusProductDocumentPlugin\Entity\ProductDocument;
use BitExpert\SyliusProductDocumentPlugin\Form\Type\DocumentTypeTranslationType;
use BitExpert\SyliusProductDocumentPlugin\Form\Type\DocumentTypeType;
use BitExpert\SyliusProductDocumentPlugin\Form\Type\ProductDocumentType;
use BitExpert\SyliusProductDocumentPlugin\Model\DocumentTypeInterface;
use BitExpert\SyliusProductDocumentPlugin\Model\DocumentTypeTranslationInterface;
use BitExpert\SyliusProductDocumentPlugin\Model\ProductDocumentInterface;
use Sylius\Bundle\CoreBundle\DependencyInjection\PrependDoctrineMigrationsTrait;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Sylius\Resource\Factory\TranslatableFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class BitExpertSyliusProductDocumentPluginExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;

    public function getAlias(): string
    {
        return 'bitexpert_sylius_product_document';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.php');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependDoctrineMigrations($container);

        $container->prependExtensionConfig('sylius_resource', [
            'mapping' => [
                'paths' => [__DIR__ . '/../../src'],
            ],
        ]);

        $container->prependExtensionConfig('sylius_resource', [
            'resources' => [
                'bitexpert_product_document.document_type' => [
                    'classes' => [
                        'model' => DocumentType::class,
                        'interface' => DocumentTypeInterface::class,
                        'controller' => DocumentTypeController::class,
                        'factory' => TranslatableFactory::class,
                        'form' => DocumentTypeType::class,
                    ],
                    'translation' => [
                        'classes' => [
                            'model' => DocumentTypeTranslation::class,
                            'interface' => DocumentTypeTranslationInterface::class,
                            'form' => DocumentTypeTranslationType::class,
                        ],
                    ],
                ],
                'bitexpert_product_document.product_document' => [
                    'classes' => [
                        'model' => ProductDocument::class,
                        'interface' => ProductDocumentInterface::class,
                        'form' => ProductDocumentType::class,
                    ],
                ],
            ],
        ]);
    }

    protected function getMigrationsNamespace(): string
    {
        return 'DoctrineMigrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@BitExpertSyliusProductDocumentPlugin/src/Migrations';
    }

    /** @return array<string> */
    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return [
            'Sylius\Bundle\CoreBundle\Migrations',
        ];
    }
}

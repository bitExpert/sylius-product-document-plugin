# Sylius Product Document Plugin

[![Build Status](https://github.com/bitExpert/sylius-product-document-plugin/actions/workflows/build.yaml/badge.svg?branch=2.2)](https://github.com/bitExpert/sylius-product-document-plugin/actions)
[![installs on Packagist](https://img.shields.io/packagist/dt/bitexpert/sylius-product-document-plugin)](https://packagist.org/packages/bitexpert/sylius-product-document-plugin/)
[![Mastodon Follow](https://img.shields.io/mastodon/follow/109408681246972700?domain=https://rheinneckar.social)](https://rheinneckar.social/@bitexpert)

The **Product Document** Plugin for *Sylius* allows you to attach documents (e.g. PDFs, images) to products and organize them by configurable document types.

### Create document types in the admin:

![Create document types in the admin](docs/assets/document_types.png)

### Attach documents to a product:

![Attach documents to a product](docs/assets/attach_documents.png)

### Download the Documents in the storefront:

![Download the Documents in the storefront:](docs/assets/download_documents.png)

## Features

* Manage document types with translatable names and sortable positions
* Attach multiple documents to a product, organized by document type
* Download documents in the storefront and in the admin

## Requirements

* PHP 8.4 or higher
* Sylius 2.0 or higher

## Installation

1. Install the plugin via Composer

```bash
composer require bitexpert/sylius-product-document-plugin
```

1. Enable the plugin

```php
<?php
# config/bundles.php
return [
    // ...

    BitExpert\SyliusProductDocumentPlugin\BitExpertSyliusProductDocumentPlugin::class => ['all' => true],
];
```

1. Import config

```yaml
# config/packages/_sylius.yaml
imports:
    # ...

    - { resource: "@BitExpertSyliusProductDocumentPlugin/config/config.yaml" }
```

2. Import routing

```yaml
# config/routes/bitexpert_product_document.yaml
bitexpert_product_document_admin:
    resource: "@BitExpertSyliusProductDocumentPlugin/config/routes/admin.yaml"
```

3. Configure the `Product` entity in `src/Entity/Product/Product.php`

Add the `BitExpert\SyliusProductDocumentPlugin\Model\HasProductDocumentsInterface` interface and the `BitExpert\SyliusProductDocumentPlugin\Entity\Trait\HasProductDocumentsTrait` trait to the entity.

```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use BitExpert\SyliusProductDocumentPlugin\Entity\Trait\HasProductDocumentsTrait;
use BitExpert\SyliusProductDocumentPlugin\Model\HasProductDocumentsInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements HasProductDocumentsInterface
{
    use HasProductDocumentsTrait;

    public function __construct()
    {
        parent::__construct();
        $this->initializeProductDocumentsCollection();
    }
}
```

4. Update your database schema

```bash
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Tests

You can run the unit tests with the following command (requires dependency installation):

```bash
./vendor/bin/phpunit
```

## Contribution

Feel free to contribute to this module by reporting issues or creating pull requests for improvements.

To run the Test Application included in the repo, refer to the [Sylius Test Application](https://docs.sylius.com/plugins-development-guide/test-application) docs.

## Credits

This plugin was inspired by the [AsdoriaSyliusProductDocumentPlugin](https://github.com/asdoria/AsdoriaSyliusProductDocumentPlugin) by Asdoria and has been rebuilt from scratch for Sylius 2.

## License

The **Sylius Product Document** Plugin for *Sylius* is released under the MIT license.

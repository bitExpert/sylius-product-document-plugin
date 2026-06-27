<?php

declare(strict_types=1);

namespace Tests\BitExpert\SyliusProductDocumentPlugin\Entity;

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

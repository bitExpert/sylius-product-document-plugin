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

namespace BitExpert\SyliusProductDocumentPlugin\Entity\Trait;

use BitExpert\SyliusProductDocumentPlugin\Entity\ProductDocument;
use BitExpert\SyliusProductDocumentPlugin\Model\ProductDocumentInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** @phpstan-ignore trait.unused */
trait HasProductDocumentsTrait
{
    /** @var Collection<int, ProductDocumentInterface> */
    #[ORM\OneToMany(targetEntity: ProductDocument::class, mappedBy: 'product', cascade: ['all'], orphanRemoval: true)]
    protected Collection $productDocuments;

    public function initializeProductDocumentsCollection(): void
    {
        $this->productDocuments = new ArrayCollection();
    }

    /** @return Collection<int, ProductDocumentInterface> */
    public function getProductDocuments(): Collection
    {
        return $this->productDocuments;
    }

    /** @return Collection<int, ProductDocumentInterface> */
    public function getDocumentsByType(string $typeCode): Collection
    {
        return $this->productDocuments->filter(
            static fn (ProductDocumentInterface $doc) => $doc->getDocumentType()?->getCode() === $typeCode,
        );
    }

    public function addProductDocument(ProductDocumentInterface $productDocument): void
    {
        if (!$this->productDocuments->contains($productDocument)) {
            $this->productDocuments->add($productDocument);
            $productDocument->setProduct($this);
        }
    }

    public function removeProductDocument(ProductDocumentInterface $productDocument): void
    {
        $this->productDocuments->removeElement($productDocument);
    }

    public function hasProductDocument(ProductDocumentInterface $productDocument): bool
    {
        return $this->productDocuments->contains($productDocument);
    }
}

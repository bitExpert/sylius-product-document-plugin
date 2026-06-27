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

namespace BitExpert\SyliusProductDocumentPlugin\Entity;

use BitExpert\SyliusProductDocumentPlugin\Model\DocumentTypeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Resource\Model\TranslatableTrait;
use Sylius\Resource\Model\TranslationInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'bitexpert_sylius_document_type')]
class DocumentType implements DocumentTypeInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private getTranslationFromTrait;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // @phpstan-ignore property.unusedType

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: 'bitexpert_product_document.admin.form.document_type.code_required')]
    private ?string $code = null;

    #[ORM\Column]
    private int $position = 0;

    /** @var Collection<int, ProductDocument> */
    #[ORM\OneToMany(targetEntity: ProductDocument::class, mappedBy: 'documentType', cascade: ['all'], orphanRemoval: true)]
    private Collection $productDocuments;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->productDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /** @return Collection<int, ProductDocument> */
    public function getProductDocuments(): Collection
    {
        return $this->productDocuments;
    }

    public function addProductDocument(ProductDocument $productDocument): void
    {
        if (!$this->productDocuments->contains($productDocument)) {
            $this->productDocuments->add($productDocument);
            $productDocument->setDocumentType($this);
        }
    }

    public function removeProductDocument(ProductDocument $productDocument): void
    {
        $this->productDocuments->removeElement($productDocument);
    }

    public function getTranslation(?string $locale = null): DocumentTypeTranslation
    {
        /** @var DocumentTypeTranslation $translation */
        $translation = $this->getTranslationFromTrait($locale);

        return $translation;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }

    protected function createTranslation(): TranslationInterface
    {
        return new DocumentTypeTranslation();
    }
}

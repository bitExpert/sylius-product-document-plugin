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
use BitExpert\SyliusProductDocumentPlugin\Model\ProductDocumentInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity]
#[ORM\Table(name: 'bitexpert_sylius_product_document')]
#[ORM\HasLifecycleCallbacks]
class ProductDocument implements ProductDocumentInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // @phpstan-ignore property.unusedType

    private ?File $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\ManyToOne(targetEntity: DocumentType::class, inversedBy: 'productDocuments')]
    #[ORM\JoinColumn(name: 'document_type_id', nullable: false)]
    private ?DocumentType $documentType = null;

    #[ORM\ManyToOne(targetEntity: 'Sylius\Component\Core\Model\ProductInterface')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?ProductInterface $product = null;

    #[ORM\Column('created_at')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(name: 'document_visibility', enumType: DocumentVisibility::class)]
    private DocumentVisibility $documentVisibility = DocumentVisibility::PUBLIC;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    public function hasFile(): bool
    {
        return $this->file !== null;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getDocumentType(): ?DocumentTypeInterface
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypeInterface $documentType): void
    {
        $this->documentType = $documentType instanceof DocumentType ? $documentType : null;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function setProduct(?ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getDocumentVisibility(): DocumentVisibility
    {
        return $this->documentVisibility;
    }

    public function setDocumentVisibility(?DocumentVisibility $documentVisibility): static
    {
        $this->documentVisibility = $documentVisibility ?? DocumentVisibility::PUBLIC;

        return $this;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}

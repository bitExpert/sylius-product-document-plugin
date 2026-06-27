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

use BitExpert\SyliusProductDocumentPlugin\Model\DocumentTypeTranslationInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Resource\Model\AbstractTranslation;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'bitexpert_sylius_document_type_translation')]
class DocumentTypeTranslation extends AbstractTranslation implements DocumentTypeTranslationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // @phpstan-ignore property.unusedType

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: 'bitexpert_product_document.admin.form.document_type.name_required')]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}

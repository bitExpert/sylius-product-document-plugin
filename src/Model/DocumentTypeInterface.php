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

namespace BitExpert\SyliusProductDocumentPlugin\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Resource\Model\ResourceInterface;
use Sylius\Resource\Model\TranslatableInterface;

interface DocumentTypeInterface extends ResourceInterface, TranslatableInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getName(): ?string;

    public function setName(?string $name): void;

    public function getPosition(): int;

    public function setPosition(int $position): void;

    /** @return Collection<int, mixed> */
    public function getProductDocuments(): Collection;
}

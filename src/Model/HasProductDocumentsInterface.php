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

interface HasProductDocumentsInterface
{
    /** @return Collection<int, ProductDocumentInterface> */
    public function getProductDocuments(): Collection;
}

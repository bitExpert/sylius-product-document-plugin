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

namespace BitExpert\SyliusProductDocumentPlugin\EventListener;

use BitExpert\SyliusProductDocumentPlugin\Model\HasProductDocumentsInterface;
use BitExpert\SyliusProductDocumentPlugin\Uploader\UploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class ProductDocumentsUploadListener
{
    public function __construct(private readonly UploaderInterface $uploader)
    {
    }

    public function uploadDocuments(GenericEvent $event): void
    {
        $subject = $event->getSubject();
        Assert::isInstanceOf($subject, HasProductDocumentsInterface::class);

        $documents = $subject->getProductDocuments();

        foreach ($documents as $document) {
            if ($document->hasFile()) {
                $this->uploader->upload($document);
            }

            if ($document->getPath() === null) {
                $documents->removeElement($document);
            }
        }
    }
}

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

namespace BitExpert\SyliusProductDocumentPlugin\Controller;

use BitExpert\SyliusProductDocumentPlugin\Uploader\UploaderInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class ProductDocumentController extends ResourceController
{
    public function downloadAction(Request $request, UploaderInterface $uploader): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        /** @var \BitExpert\SyliusProductDocumentPlugin\Model\ProductDocumentInterface $document */
        $document = $this->findOr404($configuration);

        $path = $document->getPath();
        if ($path === null) {
            throw new HttpException(Response::HTTP_NOT_FOUND, 'Document has no path.');
        }

        $extension = strtolower(pathinfo($path, \PATHINFO_EXTENSION));
        $basename = pathinfo($path, \PATHINFO_BASENAME);

        $contentType = match ($extension) {
            'pdf' => 'application/pdf',
            default => 'image/' . $extension,
        };

        $disposition = $request->query->has('download')
            ? 'attachment; filename="' . $basename . '"'
            : 'inline; filename="' . $basename . '"';

        return new Response($uploader->getContent($document), Response::HTTP_OK, [
            'Content-Type' => $contentType,
            'Content-Disposition' => $disposition,
        ]);
    }
}

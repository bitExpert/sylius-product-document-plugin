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

use BitExpert\SyliusProductDocumentPlugin\Entity\DocumentVisibility;
use BitExpert\SyliusProductDocumentPlugin\Entity\ProductDocument;
use BitExpert\SyliusProductDocumentPlugin\Uploader\UploaderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class ProductDocumentController
{
    public function __construct(
        #[Autowire(service: 'bitexpert_product_document.repository.product_document')]
        private RepositoryInterface $productDocumentRepository,
        #[Autowire(service: 'bitexpert_product_document.uploader')]
        private UploaderInterface $uploader,
        private Security $security,
    ) {
    }

    public function downloadAction(Request $request, int $id): Response
    {
        /** @var ProductDocument|null $document */
        $document = $this->productDocumentRepository->find($id);

        if (null === $document) {
            throw new NotFoundHttpException('Document not found.');
        }

        if (DocumentVisibility::LOGGED_IN === $document->getDocumentVisibility() &&
            null === $this->security->getUser()
        ) {
            throw new NotFoundHttpException('Document not found.');
        }

        return $this->buildResponse($request, $document);
    }

    public function adminDownloadAction(Request $request, int $id): Response
    {
        /** @var ProductDocument|null $document */
        $document = $this->productDocumentRepository->find($id);

        if (null === $document) {
            throw new NotFoundHttpException('Document not found.');
        }

        return $this->buildResponse($request, $document);
    }

    private function buildResponse(Request $request, ProductDocument $document): Response
    {
        $path = $document->getPath() ?? throw new NotFoundHttpException('Document has no path.');
        $info = pathinfo($path);
        $extension = strtolower($info['extension'] ?? '');
        $basename = $info['basename'] ?: 'document';
        $disposition = $request->query->has('download') ? 'attachment; ' : '';

        return new Response(
            $this->uploader->getContent($document),
            Response::HTTP_OK,
            [
                'Content-Type' => 'pdf' === $extension ? 'application/pdf' : "image/{$extension}",
                'Content-Disposition' => "{$disposition}filename=\"{$basename}\"",
            ],
        );
    }
}

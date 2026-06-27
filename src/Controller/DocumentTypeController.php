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

use BitExpert\SyliusProductDocumentPlugin\Model\DocumentTypeInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class DocumentTypeController extends ResourceController
{
    public function updatePositionsAction(Request $request): Response
    {
        /** @var array{_csrf_token?: string, documentTypes?: list<array{position: string|int, id: int}>}|null $data */
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse();
        }

        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $this->isGrantedOr403($configuration, ResourceActions::UPDATE);

        if ($configuration->isCsrfProtectionEnabled() && !$this->isCsrfTokenValid(
            'update-document-type-position',
            $data['_csrf_token'] ?? '',
        )) {
            throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid CSRF token.');
        }

        $documentTypesToUpdate = $data['documentTypes'] ?? [];

        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'], true) && $documentTypesToUpdate !== []) {
            foreach ($documentTypesToUpdate as $item) {
                if (!is_numeric($item['position'])) {
                    throw new HttpException(
                        Response::HTTP_NOT_ACCEPTABLE,
                        sprintf('Position "%s" is invalid.', $item['position']),
                    );
                }

                /** @var DocumentTypeInterface $documentType */
                $documentType = $this->repository->find($item['id']);
                $documentType->setPosition((int) $item['position']);
                $this->manager->flush();
            }
        }

        return new JsonResponse();
    }
}

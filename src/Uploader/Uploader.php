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

namespace BitExpert\SyliusProductDocumentPlugin\Uploader;

use BitExpert\SyliusProductDocumentPlugin\Model\DocumentInterface;
use League\Flysystem\FilesystemOperator;

final class Uploader implements UploaderInterface
{
    public function __construct(private readonly FilesystemOperator $filesystem)
    {
    }

    public function upload(DocumentInterface $document): void
    {
        $file = $document->getFile();
        if ($file === null) {
            return;
        }

        if ($document->getPath() !== null && $this->filesystem->fileExists($document->getPath())) {
            $this->filesystem->delete($document->getPath());
        }

        do {
            $hash = md5(uniqid((string) mt_rand(), true));
            $path = $this->buildPath($hash . '.' . $file->guessExtension());
        } while ($this->filesystem->fileExists($path));

        $document->setPath($path);

        $content = file_get_contents($file->getPathname());
        if ($content === false) {
            throw new \RuntimeException(sprintf('Failed to read file "%s".', $file->getPathname()));
        }

        $this->filesystem->write($path, $content);
    }

    public function remove(string $path): bool
    {
        if (!$this->filesystem->fileExists($path)) {
            return false;
        }

        $this->filesystem->delete($path);

        return true;
    }

    public function getContent(DocumentInterface $document): string
    {
        $path = $document->getPath() ?? throw new \RuntimeException('Document has no path.');

        return $this->filesystem->read($path);
    }

    private function buildPath(string $filename): string
    {
        return sprintf('%s/%s/%s', substr($filename, 0, 2), substr($filename, 2, 2), substr($filename, 4));
    }
}

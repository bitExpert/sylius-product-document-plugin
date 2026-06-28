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

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum DocumentVisibility: string implements TranslatableInterface
{
    case PUBLIC = 'public';
    case LOGGED_IN = 'logged_in';
    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return match ($this) {
            self::PUBLIC => $translator->trans('bitexpert_product_document.document_visibility.enum.public', locale: $locale),
            self::LOGGED_IN => $translator->trans('bitexpert_product_document.document_visibility.enum.logged_in', locale: $locale),
        };
    }

    /**
     * @return array<int, DocumentVisibility>
     */
    public static function getChoices(): array
    {
        return [
            self::PUBLIC,
            self::LOGGED_IN,
        ];
    }
}

#!/usr/bin/env php
<?php

declare(strict_types=1);

$dirName = basename(dirname(__DIR__));
$isSyliusOfficial = getenv('SYLIUS') === '1';

if ($isSyliusOfficial) {
    if (!preg_match('/^[A-Z][a-zA-Z0-9]*Plugin$/', $dirName) || str_starts_with($dirName, 'Sylius')) {
        $hasPluginSuffix = str_ends_with($dirName, 'Plugin');

        $suggestion = $dirName;
        if (str_starts_with($suggestion, 'Sylius')) {
            $suggestion = substr($suggestion, 6);
        }
        if (!$hasPluginSuffix) {
            $suggestion .= 'Plugin';
        }

        fwrite(STDERR, "\n");
        fwrite(STDERR, "  \033[41;37m ERROR \033[0m Official Sylius plugin name must match pattern: {Feature}Plugin\n");
        fwrite(STDERR, "\n");
        fwrite(STDERR, "  Current:  {$dirName}\n");
        fwrite(STDERR, "  Expected: {$suggestion}\n");
        fwrite(STDERR, "\n");
        fwrite(STDERR, "  Example:\n");
        fwrite(STDERR, "    SYLIUS=1 composer create-project sylius/plugin-skeleton MailerLitePlugin\n");
        fwrite(STDERR, "\n");

        exit(1);
    }
} else {
    if (!preg_match('/^Sylius[A-Z][a-zA-Z0-9]*Plugin$/', $dirName)) {
        $hasSyliusPrefix = str_starts_with($dirName, 'Sylius');
        $hasPluginSuffix = str_ends_with($dirName, 'Plugin');

        $suggestion = $dirName;
        if (!$hasSyliusPrefix) {
            $suggestion = 'Sylius' . $suggestion;
        }
        if (!$hasPluginSuffix) {
            $suggestion .= 'Plugin';
        }

        fwrite(STDERR, "\n");
        fwrite(STDERR, "  \033[41;37m ERROR \033[0m Community plugin name must match pattern: Sylius{Feature}Plugin\n");
        fwrite(STDERR, "\n");
        fwrite(STDERR, "  Current:  {$dirName}\n");
        fwrite(STDERR, "  Expected: {$suggestion}\n");
        fwrite(STDERR, "\n");
        fwrite(STDERR, "  Example:\n");
        fwrite(STDERR, "    composer create-project sylius/plugin-skeleton SyliusWishlistPlugin\n");
        fwrite(STDERR, "\n");

        exit(1);
    }
}

unlink(__FILE__);

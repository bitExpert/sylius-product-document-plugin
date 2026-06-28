<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use BitExpert\SyliusProductDocumentPlugin\Controller\ProductDocumentController;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(ProductDocumentController::class)
        ->autowire()
        ->tag('controller.service_arguments');
};

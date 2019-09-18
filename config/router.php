
<?php

use App\Controller\ItemController;
use App\Controller\GeneralController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    // Matches /item exactly
    $routes->add('item_list', '/item')
        ->controller([ItemController::class, 'list'])
    ;
    // Matches /item/*
    // but not /item/slug/extra-part
    $routes->add('item_show', '/item/{slug}')
        ->controller([ItemController::class, 'show'])
    ;

    $routes->add('general_show', '/{path}')
        ->controller([GeneralController::class, 'show'])
;
};
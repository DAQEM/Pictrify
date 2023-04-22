<?php

namespace Pictrify;

use Pictrify\Gateway\CreatorGateway;
use Pictrify\Gateway\PhotoAlbumGateway;

require './includes.php';

$mainController = new MainController();
$request = new Request();

$gatewayDependencyInjection = new GatewayInjection(new CreatorGateway(), new PhotoAlbumGateway());

$response = $mainController->getResponse($request, $gatewayDependencyInjection);

header('Content-Type: application/json');
echo json_encode($response);
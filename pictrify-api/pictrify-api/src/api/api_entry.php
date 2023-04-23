<?php

namespace Pictrify;

use Pictrify\Gateway\CreatorGateway;
use Pictrify\Gateway\PhotoAlbumGateway;
use Pictrify\Gateway\SectionGateway;

require './includes.php';

$gatewayDependencyInjection = new GatewayInjection(new CreatorGateway(), new PhotoAlbumGateway(), new SectionGateway());

$entryController = new EntryController($gatewayDependencyInjection);
$request = new Request();

$response = $entryController->getResponse($request);

header('Content-Type: application/json');
echo json_encode($response);
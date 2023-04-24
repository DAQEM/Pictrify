<?php

namespace Pictrify;

use Pictrify\Repository\CreatorRepository;
use Pictrify\Repository\ImageRepository;
use Pictrify\Repository\PhotoAlbumRepository;
use Pictrify\Repository\SectionItemRepository;
use Pictrify\Repository\SectionRepository;

require './includes.php';

$repositoryDependencyInjection = new RepositoryInjection(
    new CreatorRepository(), new PhotoAlbumRepository(),
    new SectionRepository(), new SectionItemRepository(),
    new ImageRepository());

$entryController = new EntryController($repositoryDependencyInjection);
$request = new Request();

$response = $entryController->getResponse($request);

header('Content-Type: application/json');
echo json_encode($response);
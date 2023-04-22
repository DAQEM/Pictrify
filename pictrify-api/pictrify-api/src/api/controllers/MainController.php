<?php

namespace Pictrify;

require './includes.php';

class MainController extends BaseController
{
    public function getResponse(Request $request, GatewayInjection $gatewayInjection): array
    {
        $creatorController = new CreatorController($gatewayInjection->getCreatorGateway());
        $photoAlbumController = new PhotoAlbumController($gatewayInjection->getPhotoAlbumGateway(), $gatewayInjection->getCreatorGateway());
        try {
            return match ($request->getExplodedPath()[1]) {
                '' => array('message' => 'Welcome to Pictrify API'),
                'creator' => $creatorController->getCreatorsResponse($request),
                'photo-album' => $photoAlbumController->getPhotoAlbumResponse($request),
                default => throw new NotFoundException()
            };
        } catch (HttpException $e) {
            http_response_code($e->getCode());
            if ($e->getReason() !== '')
                return array('error' => $e->getMessage(), 'reason' => $e->getReason());
            else
                return array('error' => $e->getMessage());
        }
    }
}
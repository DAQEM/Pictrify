<?php

namespace Pictrify;

require './includes.php';

class EntryController extends BaseController
{
    private GatewayInjection $gatewayInjection;

    public function __construct(GatewayInjection $gatewayInjection)
    {
        $this->gatewayInjection = $gatewayInjection;
    }

    public function getResponse(Request $request): array
    {
        $creatorController = new CreatorController($this->gatewayInjection->getCreatorGateway());
        $photoAlbumController = new PhotoAlbumController($this->gatewayInjection->getPhotoAlbumGateway(), $this->gatewayInjection->getCreatorGateway());
        try {
            return match ($request->getExplodedPath()[1]) {
                '' => array('message' => 'Welcome to Pictrify API'),
                'creator' => $creatorController->getResponse($request),
                'photo-album' => $photoAlbumController->getResponse($request),
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
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
        try {
            return match ($request->getExplodedPath()[1]) {
                '' => array('message' => 'Welcome to Pictrify API'),
                'creator' => $this->gatewayInjection->getCreatorController()->getResponse($request),
                'photo-album' => $this->gatewayInjection->getPhotoAlbumController()->getResponse($request),
                'section' => $this->gatewayInjection->getSectionController()->getResponse($request),
                default => throw new NotFoundException()
            };
        } catch (HttpException $ex) {
            http_response_code($ex->getCode());

            $response = array('error' => $ex->getMessage());

            if ($ex->getReason()) {
                $response['reason'] = $ex->getReason();
            }

            return $response;
        }
    }
}
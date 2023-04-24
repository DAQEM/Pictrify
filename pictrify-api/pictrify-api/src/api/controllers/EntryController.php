<?php

namespace Pictrify;

require './includes.php';

class EntryController extends BaseController
{
    private RepositoryInjection $repositoryInjection;

    public function __construct(RepositoryInjection $repositoryInjection)
    {
        $this->repositoryInjection = $repositoryInjection;
    }

    public function getResponse(Request $request): array
    {
        try {
            return match ($request->getExplodedPath()[1]) {
                '' => array('message' => 'Welcome to Pictrify API'),
                'creator' => $this->repositoryInjection->getCreatorController()->getResponse($request),
                'photo-album' => $this->repositoryInjection->getPhotoAlbumController()->getResponse($request),
                'section' => $this->repositoryInjection->getSectionController()->getResponse($request),
                'section-item' => $this->repositoryInjection->getSectionItemController()->getResponse($request),
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
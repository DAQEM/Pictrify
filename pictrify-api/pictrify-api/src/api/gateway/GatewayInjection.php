<?php

namespace Pictrify;

class GatewayInjection
{
    private ICreatorGateway $creatorGateway;
    private IPhotoAlbumGateway $photoAlbumGateway;

    public function __construct(ICreatorGateway $creatorGateway, IPhotoAlbumGateway $photoAlbumGateway)
    {
        $this->creatorGateway = $creatorGateway;
        $this->photoAlbumGateway = $photoAlbumGateway;
    }

    public function getCreatorGateway(): ICreatorGateway
    {
        return $this->creatorGateway;
    }

    public function getPhotoAlbumGateway(): IPhotoAlbumGateway
    {
        return $this->photoAlbumGateway;
    }
}
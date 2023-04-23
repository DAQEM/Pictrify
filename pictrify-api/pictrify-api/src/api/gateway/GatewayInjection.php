<?php

namespace Pictrify;

class GatewayInjection
{
    private ICreatorGateway $creatorGateway;
    private IPhotoAlbumGateway $photoAlbumGateway;
    private ISectionGateway $sectionGateway;

    public function __construct(
        ICreatorGateway $creatorGateway,
        IPhotoAlbumGateway $photoAlbumGateway,
        ISectionGateway $sectionGateway
    )
    {
        $this->creatorGateway = $creatorGateway;
        $this->photoAlbumGateway = $photoAlbumGateway;
        $this->sectionGateway = $sectionGateway;
    }

    public function getCreatorController() : CreatorController
    {
        return new CreatorController(new CreatorService($this->creatorGateway));
    }

    public function getPhotoAlbumController() : PhotoAlbumController
    {
        return new PhotoAlbumController(new PhotoAlbumService($this->photoAlbumGateway, $this->creatorGateway));
    }

    public function getSectionController() : SectionController
    {
        return new SectionController(new SectionService($this->sectionGateway, $this->photoAlbumGateway, $this->creatorGateway));
    }
}
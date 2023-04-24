<?php

namespace Pictrify;

use Pictrify\interfaces\ICreatorGateway;
use Pictrify\interfaces\IPhotoAlbumGateway;
use Pictrify\interfaces\ISectionGateway;
use Pictrify\interfaces\ISectionItemGateway;

class GatewayInjection
{
    private ICreatorGateway $creatorGateway;
    private IPhotoAlbumGateway $photoAlbumGateway;
    private ISectionGateway $sectionGateway;
    private ISectionItemGateway $sectionItemGateway;

    public function __construct(
        ICreatorGateway     $creatorGateway,
        IPhotoAlbumGateway  $photoAlbumGateway,
        ISectionGateway     $sectionGateway,
        ISectionItemGateway $sectionItemGateway
    )
    {
        $this->creatorGateway = $creatorGateway;
        $this->photoAlbumGateway = $photoAlbumGateway;
        $this->sectionGateway = $sectionGateway;
        $this->sectionItemGateway = $sectionItemGateway;
    }

    private function getCreatorService(): CreatorService
    {
        return new CreatorService($this->creatorGateway);
    }

    private function getPhotoAlbumService(): PhotoAlbumService
    {
        return new PhotoAlbumService($this->photoAlbumGateway, $this->getCreatorService());
    }

    private function getSectionService(): SectionService
    {
        return new SectionService($this->sectionGateway, $this->getPhotoAlbumService());
    }

    private function getSectionItemService(): SectionItemService
    {
        return new SectionItemService($this->sectionItemGateway, $this->getSectionService());
    }


    public function getCreatorController(): CreatorController
    {
        return new CreatorController($this->getCreatorService());
    }

    public function getPhotoAlbumController(): PhotoAlbumController
    {
        return new PhotoAlbumController($this->getPhotoAlbumService());
    }

    public function getSectionController(): SectionController
    {
        return new SectionController($this->getSectionService());
    }

    public function getSectionItemController(): SectionItemController
    {
        return new SectionItemController($this->getSectionItemService());
    }
}
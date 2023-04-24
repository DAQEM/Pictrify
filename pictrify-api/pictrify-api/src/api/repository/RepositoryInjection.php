<?php

namespace Pictrify;

use Pictrify\interfaces\ICreatorRepository;
use Pictrify\interfaces\IPhotoAlbumRepository;
use Pictrify\interfaces\ISectionItemRepository;
use Pictrify\interfaces\ISectionRepository;

class RepositoryInjection
{
    private ICreatorRepository $creatorRepository;
    private IPhotoAlbumRepository $photoAlbumRepository;
    private ISectionRepository $sectionRepository;
    private ISectionItemRepository $sectionItemRepository;

    public function __construct(
        ICreatorRepository     $creatorRepository,
        IPhotoAlbumRepository  $photoAlbumRepository,
        ISectionRepository     $sectionRepository,
        ISectionItemRepository $sectionItemRepository
    )
    {
        $this->creatorRepository = $creatorRepository;
        $this->photoAlbumRepository = $photoAlbumRepository;
        $this->sectionRepository = $sectionRepository;
        $this->sectionItemRepository = $sectionItemRepository;
    }

    private function getCreatorService(): CreatorService
    {
        return new CreatorService($this->creatorRepository);
    }

    private function getPhotoAlbumService(): PhotoAlbumService
    {
        return new PhotoAlbumService($this->photoAlbumRepository, $this->getCreatorService());
    }

    private function getSectionService(): SectionService
    {
        return new SectionService($this->sectionRepository, $this->getPhotoAlbumService());
    }

    private function getSectionItemService(): SectionItemService
    {
        return new SectionItemService($this->sectionItemRepository, $this->getSectionService());
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
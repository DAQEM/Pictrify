<?php

namespace Pictrify;

use Pictrify\interfaces\ICreatorRepository;
use Pictrify\interfaces\IImageRepository;
use Pictrify\interfaces\IPhotoAlbumCommentRepository;
use Pictrify\interfaces\IPhotoAlbumRepository;
use Pictrify\interfaces\ISectionItemRepository;
use Pictrify\interfaces\ISectionRepository;

class RepositoryInjection
{
    private ICreatorRepository $creatorRepository;
    private IPhotoAlbumRepository $photoAlbumRepository;
    private ISectionRepository $sectionRepository;
    private ISectionItemRepository $sectionItemRepository;
    private IImageRepository $imageRepository;
    private IPhotoAlbumCommentRepository $photoAlbumCommentRepository;
    private IImageCommentRepository $imageCommentRepository;

    public function __construct(
        ICreatorRepository           $creatorRepository,
        IPhotoAlbumRepository        $photoAlbumRepository,
        ISectionRepository           $sectionRepository,
        ISectionItemRepository       $sectionItemRepository,
        IImageRepository             $imageRepository,
        IPhotoAlbumCommentRepository $photoAlbumCommentRepository,
        IImageCommentRepository      $imageCommentRepository
    )
    {
        $this->creatorRepository = $creatorRepository;
        $this->photoAlbumRepository = $photoAlbumRepository;
        $this->sectionRepository = $sectionRepository;
        $this->sectionItemRepository = $sectionItemRepository;
        $this->imageRepository = $imageRepository;
        $this->photoAlbumCommentRepository = $photoAlbumCommentRepository;
        $this->imageCommentRepository = $imageCommentRepository;
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

    private function getImageService(): ImageService
    {
        return new ImageService($this->imageRepository, $this->getSectionItemService());
    }

    private function getPhotoAlbumCommentService(): PhotoAlbumCommentService
    {
        return new PhotoAlbumCommentService($this->photoAlbumCommentRepository, $this->getPhotoAlbumService(), $this->getCreatorService());
    }

    private function getImageCommentService(): ImageCommentService
    {
        return new ImageCommentService($this->imageCommentRepository, $this->getImageService(), $this->getCreatorService());
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

    public function getImageController(): ImageController
    {
        return new ImageController($this->getImageService());
    }

    public function getPhotoAlbumCommentController(): PhotoAlbumCommentController
    {
        return new PhotoAlbumCommentController($this->getPhotoAlbumCommentService());
    }

    public function getImageCommentController(): ImageCommentController
    {
        return new ImageCommentController($this->getImageCommentService());
    }
}
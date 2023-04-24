<?php

namespace Pictrify;

use Pictrify\interfaces\IImageRepository;
use UTCDate;

class ImageService extends BaseService
{
    private IImageRepository $imageRepository;
    private SectionItemService $sectionItemService;

    public function __construct(IImageRepository $imageRepository, SectionItemService $sectionItemService)
    {
        $this->imageRepository = $imageRepository;
        $this->sectionItemService = $sectionItemService;
    }

    public function getAllImages(): array
    {
        return $this->imageRepository->getAllImages();
    }

    /**
     * @throws NotFoundException the image does not exist.
     */
    public function getImageById(string $id): array
    {
        $result = $this->imageRepository->getImageById($id);

        return $result ?: throw new NotFoundException();
    }

    public function getImageBySectionItemId(string $sectionItemId): array
    {
        return $this->imageRepository->getImageBySectionItemId($sectionItemId);
    }

    public function getAllImagesByCreatorId(string $creatorId): array
    {
        return $this->imageRepository->getAllImagesByCreatorId($creatorId);
    }

    public function getAllImagesByPhotoAlbumId(string $photoAlbumId): array
    {
        return $this->imageRepository->getAllImagesByPhotoAlbumId($photoAlbumId);
    }

    public function getAllImagesBySectionId(string $sectionId): array
    {
        return $this->imageRepository->getAllImagesBySectionId($sectionId);
    }

    /**
     * @throws ForbiddenException if sectionItemId does not exist or if title, description, caption, date or url is not valid
     */
    public function createImage($sectionItemId, $title, $description, $caption, $date, $url): array
    {
        //url example: "images/2023/04/24/682d9255-080e-46cb-877f-4ca236ab94c4.jpg"
        $id = explode('.', explode('/', $url)[4])[0];
        $creationDate = UTCDate::nowISO();

        if ($this->imageIdExists($id)) {
            throw new ForbiddenException('Image id already exists');
        }

        if (!$this->sectionItemService->sectionItemIdExists($sectionItemId)) {
            throw new ForbiddenException('SectionItem does not exist');
        }

        if (!$this->titleValid($title)) {
            throw new ForbiddenException('Title is not valid');
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException('Description is not valid');
        }

        if (!$this->captionValid($caption)) {
            throw new ForbiddenException('Caption is not valid');
        }

        if (!$this->dateValid($date)) {
            throw new ForbiddenException('Date is not valid');
        }

        if (!$this->urlValid($url)) {
            throw new ForbiddenException('Url is not valid');
        }

        $success = $this->imageRepository->createImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $creationDate);

        return $this->createdResponse($success, [
            'id' => $id,
            'sectionItemId' => $sectionItemId,
            'title' => $title,
            'description' => $description,
            'caption' => $caption,
            'date' => $date,
            'url' => $url,
            'creationDate' => $creationDate
        ]);
    }

    /**
     * @throws ForbiddenException if title, description, caption, date or url is not valid.
     */
    public function updateImage($id, $sectionItemId, $title, $description, $caption, $date, $url): array
    {
        $editDate = UTCDate::nowISO();

        if (!$this->titleValid($title)) {
            throw new ForbiddenException('Title is not valid');
        }

        if (!$this->descriptionValid($description)) {
            throw new ForbiddenException('Description is not valid');
        }

        if (!$this->captionValid($caption)) {
            throw new ForbiddenException('Caption is not valid');
        }

        if (!$this->dateValid($date)) {
            throw new ForbiddenException('Date is not valid');
        }

        if (!$this->urlValid($url)) {
            throw new ForbiddenException('Url is not valid');
        }

        $success = $this->imageRepository->updateImage($id, $sectionItemId, $title, $description, $caption, $date, $url, $editDate);

        return $this->updatedResponse($success, [
            'id' => $id,
            'sectionItemId' => $sectionItemId,
            'title' => $title,
            'description' => $description,
            'caption' => $caption,
            'date' => $date,
            'url' => $url,
            'editDate' => $editDate
        ]);
    }

    public function deleteImage($id): array
    {
        $success = $this->imageRepository->deleteImage($id);

        return $this->deletedResponse($success, [
            'id' => $id
        ], 'Image with this id could not be found');
    }

    public function imageIdExists(string $id): bool
    {
        try {
            $this->getImageById($id);
            return true;
        } catch (NotFoundException) {
            return false;
        }
    }

    public function titleValid($title): bool
    {
        /**
         * This regex matches a string of 2 to 64 characters that starts and
         * ends with an alphanumeric character, allows spaces, dashes, colons,
         * and forward slashes in between, but does not allow consecutive
         * spaces or more than one colon or forward slash in a row.
         */
        return preg_match('/^(?!\s)(?!.*\s{2})(?!.*:{2})(?!.*\/{2})[a-zA-Z0-9][a-zA-Z0-9\s\/\-:]{1,62}[a-zA-Z0-9](?<!\s)$/', $title);
    }

    public function descriptionValid($description): bool
    {
        /**
         * This regex matches a string of 1 to 4096 characters that contains
         * only alphanumeric characters, spaces, and the following special
         * characters: - , . ! ?
         */
        return preg_match('/^[\s\S]{0,4096}$/', $description);
    }

    public function captionValid($caption): bool
    {
        /**
         * This regex matches a string of 1 to 256 characters that contains
         * only alphanumeric characters, spaces, and the following special
         * characters: - , . ! ?
         */
        return preg_match('/^[a-zA-Z0-9\s\-_,.!?]{1,256}$/', $caption);
    }

    public function dateValid($date): bool
    {
        return UTCDate::isValidISO($date);
    }

    public function urlValid($url): bool
    {
        /**
         * This regular expression matches file paths that start
         * with "images/", followed by a date in the format YYYY/MM/DD,
         * and a UUID in the format 8-4-4-4-12, ending with a valid image
         * file extension (png, jpg, jpeg, or gif).
         */
        return preg_match('/^images\/\d{4}\/\d{2}\/\d{2}\/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[8-9a-bA-B][0-9a-fA-F]{3}-[0-9a-fA-F]{12}\.(png|jpg|jpeg|gif)$/', $url);
    }
}
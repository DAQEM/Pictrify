<?php

namespace Pictrify;

use Guid;
use UTCDate;

class ImageCommentService extends BaseService
{
    private IImageCommentRepository $imageCommentRepository;
    private ImageService $imageService;
    private CreatorService $creatorService;

    public function __construct(IImageCommentRepository $imageCommentRepository,
                                ImageService            $imageService,
                                CreatorService          $creatorService)
    {
        $this->imageCommentRepository = $imageCommentRepository;
        $this->imageService = $imageService;
        $this->creatorService = $creatorService;
    }

    public function getAllImageComments(): array
    {
        return $this->imageCommentRepository->getAllImageComments();
    }

    /**
     * @throws NotFoundException if the image comment is not found.
     */
    public function getImageCommentById(string $id): array
    {
        $result = $this->imageCommentRepository->getImageCommentById($id);

        return $result ?: throw new NotFoundException();
    }

    public function getImageCommentsByImageId(string $imageId): array
    {
        return $this->imageCommentRepository->getImageCommentsByImageId($imageId);
    }

    public function getImageCommentsByCreatorId(string $creatorId): array
    {
        return $this->imageCommentRepository->getImageCommentsByCreatorId($creatorId);
    }

    /**
     * @throws ForbiddenException if the image or creator does not exist or the text is not valid.
     */
    public function createImageComment(string $imageId, string $creatorId, string $text): array
    {
        $id = Guid::newGuid();
        $createdDate = UTCDate::nowISO();

        if (!$this->imageService->imageIdExists($imageId)) {
            throw new ForbiddenException('The image does not exist.');
        }

        if (!$this->creatorService->creatorIdExists($creatorId)) {
            throw new ForbiddenException('The creator does not exist.');
        }

        if (!$this->textValid($text)) {
            throw new ForbiddenException('The text is not valid.');
        }

        $success = $this->imageCommentRepository->createImageComment($id, $imageId, $creatorId, $text, $createdDate);

        return $this->createdResponse($success, [
            'id' => $id,
            'imageId' => $imageId,
            'creatorId' => $creatorId,
            'text' => $text,
            'createdDate' => $createdDate
        ]);
    }

    /**
     * @throws ForbiddenException if the text is not valid.
     */
    public function updateImageComment(string $id, string $text): array
    {
        $editDate = UTCDate::nowISO();

        if (!$this->textValid($text)) {
            throw new ForbiddenException('The text is not valid.');
        }

        $success = $this->imageCommentRepository->updateImageComment($id, $text, $editDate);

        return $this->updatedResponse($success, [
            'id' => $id,
            'text' => $text,
            'editDate' => $editDate
        ]);
    }

    /**
     * @throws NotFoundException if the image comment is not found.
     */
    public function deleteImageComment(string $id): array
    {
        $success = $this->imageCommentRepository->deleteImageComment($id);

        return $this->deletedResponse($success, [
            'id' => $id
        ], 'The image comment does not exist.');
    }

    private function textValid(string $text): bool
    {
        return preg_match('/^[\s\S]{0,512}$/', $text);
    }
}
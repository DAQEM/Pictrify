<?php

namespace Pictrify;

use Guid;
use Pictrify\interfaces\IPhotoAlbumCommentRepository;
use UTCDate;

class PhotoAlbumCommentService extends BaseService
{
    private IPhotoAlbumCommentRepository $photoAlbumCommentRepository;
    private PhotoAlbumService $photoAlbumService;
    private CreatorService $creatorService;

    public function __construct(IPhotoAlbumCommentRepository $photoAlbumCommentRepository,
                                PhotoAlbumService            $photoAlbumService,
                                CreatorService               $creatorService)
    {
        $this->photoAlbumCommentRepository = $photoAlbumCommentRepository;
        $this->photoAlbumService = $photoAlbumService;
        $this->creatorService = $creatorService;
    }

    public function getAllPhotoAlbumComments(): array
    {
        return $this->photoAlbumCommentRepository->getAllPhotoAlbumComments();
    }

    /**
     * @throws NotFoundException if the photo album comment is not found.
     */
    public function getPhotoAlbumCommentById(string $id): array
    {
        $result = $this->photoAlbumCommentRepository->getPhotoAlbumCommentById($id);

        return $result ?: throw new NotFoundException();
    }

    public function getPhotoAlbumCommentsByPhotoAlbumId(string $photoAlbumId): array
    {
        return $this->photoAlbumCommentRepository->getPhotoAlbumCommentsByPhotoAlbumId($photoAlbumId);
    }

    public function getPhotoAlbumCommentsByCreatorId(string $creatorId): array
    {
        return $this->photoAlbumCommentRepository->getPhotoAlbumCommentsByCreatorId($creatorId);
    }

    /**
     * @throws ForbiddenException if the photo album or creator does not exist or the text is not valid.
     */
    public function createPhotoAlbumComment(string $photoAlbumId, string $creatorId, string $text): array
    {
        $id = Guid::newGuid();
        $createdDate = UTCDate::nowISO();

        if (!$this->photoAlbumService->photoAlbumIdExists($photoAlbumId)) {
            throw new ForbiddenException('The photo album does not exist.');
        }

        if (!$this->creatorService->creatorIdExists($creatorId)) {
            throw new ForbiddenException('The creator does not exist.');
        }

        if (!$this->validText($text)) {
            throw new ForbiddenException('The text is not valid.');
        }

        $success = $this->photoAlbumCommentRepository->createComment($id, $photoAlbumId, $creatorId, $text, $createdDate);

        return $this->createdResponse($success, [
            'id' => $id,
            'photoAlbumId' => $photoAlbumId,
            'creatorId' => $creatorId,
            'text' => $text,
            'createdDate' => $createdDate
        ]);
    }

    /**
     * @throws ForbiddenException if the text is not valid.
     */
    public function updatePhotoAlbumComment(string $id, string $text): array
    {
        $editDate = UTCDate::nowISO();

        if (!$this->validText($text)) {
            throw new ForbiddenException('The text is not valid.');
        }

        $success = $this->photoAlbumCommentRepository->updateComment($id, $text, $editDate);

        return $this->updatedResponse($success, [
            'id' => $id,
            'text' => $text,
            'editDate' => $editDate
        ]);
    }

    public function deletePhotoAlbumComment(string $id): array
    {
        $success = $this->photoAlbumCommentRepository->deleteComment($id);

        return $this->deletedResponse($success, [
            'id' => $id
        ]);
    }

    private function validText(string $text): bool
    {
        return preg_match('/^[\s\S]{0,512}$/', $text);
    }
}
<?php

namespace Pictrify\interfaces;

interface IPhotoAlbumCommentRepository
{
    public function getAllPhotoAlbumComments(): array;

    public function getPhotoAlbumCommentById($id): ?array;

    public function getPhotoAlbumCommentsByPhotoAlbumId($photoAlbumId): ?array;

    public function getPhotoAlbumCommentsByCreatorId($creatorId): ?array;

    public function createComment($id, $photoAlbumId, $creatorId, $text, $createdDate): bool;

    public function updateComment($id, $text, $editDate): bool;

    public function deleteComment($id): bool;
}
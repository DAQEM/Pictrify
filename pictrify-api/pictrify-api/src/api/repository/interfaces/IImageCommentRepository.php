<?php

namespace Pictrify;

interface IImageCommentRepository
{
    public function getAllImageComments(): array;

    public function getImageCommentById($id): ?array;

    public function getImageCommentsByImageId($imageId): ?array;

    public function getImageCommentsByCreatorId($creatorId): ?array;

    public function createImageComment($id, $imageId, $creatorId, $text, $createDate): bool;

    public function updateImageComment($id, $text, $editDate): bool;

    public function deleteImageComment($id): bool;
}
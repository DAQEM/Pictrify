<?php

namespace Pictrify\interfaces;

use Pictrify\Request;

interface IHttpDelete
{
    public function handleDeleteRequest(Request $request): array;
}
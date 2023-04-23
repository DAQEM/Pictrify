<?php

namespace Pictrify\interfaces;

use Pictrify\Request;

interface IHttpPost
{
    public function handlePostRequest(Request $request): array;
}
<?php

namespace Pictrify\interfaces;

use Pictrify\Request;

interface IHttpGet
{
    public function handleGetRequest(Request $request): array;
}
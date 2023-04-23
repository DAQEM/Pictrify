<?php

namespace Pictrify\interfaces;

use Pictrify\Request;

interface IHttpPut
{
    public function handlePutRequest(Request $request): array;
}
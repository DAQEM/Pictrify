<?php

namespace Pictrify\interfaces;

use Pictrify\Request;

interface IController
{
    public function getResponse(Request $request): array;
}
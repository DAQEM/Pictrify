<?php

namespace Pictrify;

use Pictrify\interfaces\IController;

abstract class BaseController implements IController
{
    abstract public function getResponse(Request $request): array;
}
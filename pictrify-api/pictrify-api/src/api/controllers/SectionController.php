<?php

namespace Pictrify;

use Pictrify\interfaces\IHttpGet;

class SectionController extends BaseController implements IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{

    /**
     * @throws NotFoundException if the section is not found.
     * @throws MethodNotAllowedException if the method is not allowed.
     * @throws BadRequestException if the json body is not valid.
     */
    public function getResponse(Request $request): array
    {
        return match ($request->getMethod()) {
            'GET' => $this->getSections($request),
            'POST' => $this->createSection($request),
            'PUT' => $this->updateSection($request),
            'DELETE' => $this->deleteSection($request),
            default => throw new MethodNotAllowedException(),
        };
    }
}
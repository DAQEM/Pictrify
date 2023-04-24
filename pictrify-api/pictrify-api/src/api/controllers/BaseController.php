<?php

namespace Pictrify;

use Pictrify\interfaces\IController;
use Pictrify\interfaces\IHttpDelete;
use Pictrify\interfaces\IHttpGet;
use Pictrify\interfaces\IHttpPost;
use Pictrify\interfaces\IHttpPut;

abstract class BaseController implements IController, IHttpGet, IHttpPost, IHttpPut, IHttpDelete
{
    /**
     * @throws MethodNotAllowedException if the method is not allowed.
     */
    public function getResponse(Request $request): array
    {
        return match ($request->getMethod()) {
            'GET' => $this->handleGetRequest($request),
            'POST' => $this->handlePostRequest($request),
            'PUT' => $this->handlePutRequest($request),
            'DELETE' => $this->handleDeleteRequest($request),
            default => throw new MethodNotAllowedException(),
        };
    }

    /**
     * @throws MethodNotAllowedException if the method is not allowed.
     */
    public function handleGetRequest(Request $request): array
    {
        throw new MethodNotAllowedException();
    }

    /**
     * @throws MethodNotAllowedException if the method is not allowed.
     */
    public function handlePostRequest(Request $request): array
    {
        throw new MethodNotAllowedException();
    }

    /**
     * @throws MethodNotAllowedException if the method is not allowed.
     */
    public function handlePutRequest(Request $request): array
    {
        throw new MethodNotAllowedException();
    }

    /**
     * @throws MethodNotAllowedException if the method is not allowed.
     */
    public function handleDeleteRequest(Request $request): array
    {
        throw new MethodNotAllowedException();
    }
}
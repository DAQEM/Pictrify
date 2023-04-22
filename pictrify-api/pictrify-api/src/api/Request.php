<?php

namespace Pictrify;

class Request
{
    private string $method;
    private string $path;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExplodedPath(): array
    {
        $explode_path = explode('/', $this->getPath());
        array_shift($explode_path);
        return $explode_path;
    }

    /**
     * @throws BadRequestException if the key is not set in the json body.
     */
    public function getJson(string $key = null): mixed
    {
        $json = json_decode(file_get_contents('php://input'), true);

        if ($key === null) {
            return $json;
        } else {
            if (isset($json[$key])) {
                return $json[$key];
            } else {
                throw new BadRequestException("The key '$key' is not set in the json body.");
            }
        }
    }

    /**
     * @throws BadRequestException if the key is not a string in the json body.
     */
    public function getJsonString(string $key): string
    {
        $json = $this->getJson($key);
        if (is_string($json)) {
            return $json;
        } else {
            throw new BadRequestException("The key '$key' is not a string in the json body.");
        }
    }
}
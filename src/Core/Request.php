<?php

namespace TicTacToe\Core;

/**
 * Class Request
 */
class Request
{
    /**
     * @var array
     */
    protected array $query;

    /**
     * @var array
     */
    protected array $request;

    /**
     * @var null
     */
    protected $content;

    /**
     * @var array
     */
    protected array $server;

    /**
     * Request constructor.
     * @param array $query
     * @param array $request
     * @param array $server
     * @param null $content
     */
    public function __construct(array $query = [], array $request = [], array $server = [], $content = null)
    {
        $this->query = $query;
        $this->request = $request;
        $this->server = $server;
        $this->content = $content;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function queryHas(string $key)
    {
        return isset($this->query[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getQueryParam(string $key)
    {
        return $this->query[$key] ?? null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function requestHas(string $key)
    {
        return isset($this->request[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getRequestParam(string $key)
    {
        return $this->request[$key] ?? null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function serverHas(string $key)
    {
        return isset($this->server[$key]);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getServerParam(string $key)
    {
        return $this->server[$key] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getContent()
    {
        return $this->content;
    }
}

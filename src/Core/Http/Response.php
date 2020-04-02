<?php

namespace TicTacToe\Core\Http;

/**
 * Class Response
 */
class Response
{
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    const REQUEST_STATUS = [
        self::HTTP_OK => 'OK',
        self::HTTP_NOT_FOUND => 'Not Found',
        self::HTTP_BAD_REQUEST => 'Bad request',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];

    /**
     * @var mixed|null
     */
    protected $content;

    /**
     * @var int
     */
    protected int $code;

    /**
     * @var array
     */
    protected array $header;

    /**
     * Response constructor.
     * @param $content
     * @param int $code
     * @param array $header
     */
    public function __construct($content = null, int $code = self::HTTP_OK, array $header = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return self::REQUEST_STATUS[$this->code] ?? self::REQUEST_STATUS[self::HTTP_INTERNAL_SERVER_ERROR];
    }

    /**
     * @return mixed|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }
}

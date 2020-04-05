<?php


namespace TicTacToe\Core\Router;


class Route
{
    /**
     * @var string
     */
    protected string $controllerName;

    /**
     * @var string
     */
    protected string $actionName;

    /**
     * @var array|null
     */
    protected ?array $params = [];

    /**
     * @var string|null
     */
    protected ?string $name;

    /**
     * Route constructor.
     * @param string $controllerName
     * @param string $actionName
     * @param array|null $params
     * @param string|null $name
     */
    public function __construct(string $controllerName, string $actionName, ?array $params, ?string $name)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}

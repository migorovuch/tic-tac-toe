<?php

namespace TicTacToe\Core\Serializer;

use ElisDN\Hydrator\Hydrator;
use RuntimeException;
use TicTacToe\Core\Http\Response;
use TicTacToe\Core\Service;
use Zumba\JsonSerializer\JsonSerializer as ZumbaJsonSerializer;
use ReflectionClass;
use ReflectionException;

/**
 * Class JsonSerializer
 */
class JsonSerializer implements SerializerInterface, Service
{
    /**
     * @var ZumbaJsonSerializer
     */
    protected ZumbaJsonSerializer $jsonSerializer;

    /**
     * @var Hydrator
     */
    protected Hydrator $hydrator;

    /**
     * Serializer constructor.
     * @param ZumbaJsonSerializer $jsonSerializer
     * @param Hydrator $hydrator
     */
    public function __construct(ZumbaJsonSerializer $jsonSerializer, Hydrator $hydrator)
    {
        $this->jsonSerializer = $jsonSerializer;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function serialize($data): string
    {
        $serializedData = '';
        try {
            if (is_array($data)) {
                $data = $this->extractArray($data);
            } elseif (is_object($data)) {
                $data = $this->extractObject($data);
            }
            $serializedData = $this->jsonSerializer->serialize($data);
        } catch (ReflectionException $exception) {
            $serializedData = json_encode(['reason' => $exception->getMessage()]);
        }

        return $serializedData;
    }

    /**
     * @param array $data
     * @return array
     * @throws ReflectionException
     */
    protected function extractArray(array $data): array
    {
        foreach ($data as &$item) {
            if (is_array($item)) {
                $item = $this->extractArray($item);
            } elseif (is_object($item)) {
                $item = $this->extractObject($item);
            }
        }

        return $data;
    }

    /**
     * @param object $object
     * @return array
     * @throws ReflectionException
     */
    protected function extractObject(object $object): array
    {
        $fields = [];
        $objectReflection = new ReflectionClass(get_class($object));
        foreach ($objectReflection->getProperties() as $property) {
            $fields[] = $property->getName();
        }

        return $this->hydrator->extract($object, $fields);
    }

    /**
     * @inheritDoc
     * @throws \ReflectionException
     */
    public function unserialize(string $data, string $className = null)
    {
        $unserializedData = $this->jsonSerializer->unserialize($data);
        if (is_object($unserializedData)) {
            throw new RuntimeException(Response::REQUEST_STATUS[Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
        if (!$className) {
            return $unserializedData;
        }
        if (!class_exists($className)) {
            throw new RuntimeException('Class not found '.$className);
        }

        return $this->hydrator->hydrate($className, $unserializedData);
    }
}

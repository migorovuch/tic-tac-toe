<?php

namespace TicTacToe\Core;

use ElisDN\Hydrator\Hydrator;
use http\Exception\RuntimeException;
use Zumba\JsonSerializer\JsonSerializer as ZumbaJsonSerializer;

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
        return $this->jsonSerializer->serialize($data);
    }

    /**
     * @inheritDoc
     */
    public function unserialize(string $className, string $data)
    {
        $unserializedData = $this->jsonSerializer->unserialize($data);
        if(is_object($unserializedData)) {
            return $unserializedData;
        }
        if (!class_exists($className)) {
            throw new RuntimeException('Class not found '.$className);
        }

        return $this->hydrator->hydrate($className, $unserializedData);
    }
}

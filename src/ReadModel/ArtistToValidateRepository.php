<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Symfony\Component\Serializer\SerializerInterface;

class ArtistToValidateRepository implements Repository
{
    private Connection $connection;
    private SerializerInterface $serializer;
    private string $tableName;

    public function __construct(
        Connection $connection,
        SerializerInterface $serializer,
        string $tableName
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->tableName = $tableName;
    }

    public function save(Identifiable $readModel): void
    {
        /** @var ArtistToValidate $read */
        $read = $readModel;

        $this->connection->insert($this->tableName, [
            'uuid' => $read->getId(),
            'externalId' => $read->externalId(),
            'status' => $read->status(),
            'counter' => $read->counter()
        ]);
    }

    public function find($id): ?Identifiable
    {
        $row = $this->connection->fetchOne($id);

        if (false === $row) {
            return null;
        }

        return $this->serializer->deserialize($row, ArtistToValidate::class, 'array');
    }

    public function findBy(array $fields): array
    {
        return [];
    }

    public function findAll(): array
    {
        return [];
    }

    public function remove($id): void
    {
    }

    public function configureSchema(Schema $schema)
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    public function configureTable(Schema $schema): Table
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('uuid', 'guid', ['length' => 36]);
        $table->addColumn('externalId', 'integer');
        $table->addColumn('status', 'text');
        $table->addColumn('count', 'integer');
        $table->setPrimaryKey(['uuid']);

        return $table;
    }
}

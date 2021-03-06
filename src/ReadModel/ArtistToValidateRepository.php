<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Broadway\Serializer\Serializer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;

class ArtistToValidateRepository implements Repository
{
    private Connection $connection;
    private Serializer $serializer;
    private string $tableName;

    public function __construct(
        Connection $connection,
        Serializer $serializer,
        string $tableName
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->tableName = $tableName;
    }

    /**
     * @param ArtistToValidate $readModel
     */
    public function save(Identifiable $readModel): void
    {
        $id = [
            'id' => $readModel->getId()
        ];

        $data = [
            'external_id' => $readModel->externalId(),
            'status' => $readModel->status(),
            'count' => $readModel->count()
        ];

        try {
            $this->connection->insert($this->tableName, array_merge($id, $data));
        } catch (UniqueConstraintViolationException $e) {
            $this->connection->update($this->tableName, $data, $id);
        }
    }

    public function find($id): ?Identifiable
    {
        $row = $this->connection->fetchAssociative(sprintf('SELECT * FROM %s WHERE id = ?', $this->tableName), [$id]);

        if (false === $row) {
            return null;
        }

        return $this->serializer->deserialize([
            'class' => ArtistToValidate::class,
            'payload' => $row
        ]);
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

    public function configureSchema(Schema $schema): ?Table
    {
        if ($schema->hasTable($this->tableName)) {
            return null;
        }

        return $this->configureTable($schema);
    }

    private function configureTable(Schema $schema): Table
    {
        $table = $schema->createTable($this->tableName);
        $table->addColumn('id', Types::GUID, ['length' => 36]);
        $table->addColumn('external_id', Types::INTEGER);
        $table->addColumn('status', Types::TEXT);
        $table->addColumn('count', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        return $table;
    }
}

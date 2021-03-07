<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Broadway\Serializer\Serializer;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;

class AdmissionToValidateRepository implements Repository
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
     * @param AdmissionToValidate $readModel
     */
    public function save(Identifiable $readModel): void
    {
        $this->connection->insert($this->tableName, [
            'id' => $readModel->getId(),
            'item_id' => $readModel->itemId(),
            'user_id' => $readModel->userId()
        ]);
    }

    public function find($id): ?Identifiable
    {
        $row = $this->connection->fetchAssociative(sprintf('SELECT * FROM %s WHERE id = ?', $this->tableName), [$id]);

        if (false === $row) {
            return null;
        }

        return $this->serializer->deserialize([
            'class' => AdmissionToValidate::class,
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
        $table->addColumn('item_id', Types::INTEGER);
        $table->addColumn('user_id', Types::INTEGER);
        $table->setPrimaryKey(['id']);

        return $table;
    }
}

<?php

/*
 * This file is part of the broadway/broadway-demo package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\Repository;
use Broadway\ReadModel\RepositoryFactory;
use Doctrine\DBAL\Connection;
use Symfony\Component\Serializer\SerializerInterface;

class DBALRepositoryFactory implements RepositoryFactory
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

    public function create(string $name, string $class): Repository
    {
        return new ArtistToValidateRepository($this->connection, $this->serializer, $this->tableName);
    }
}

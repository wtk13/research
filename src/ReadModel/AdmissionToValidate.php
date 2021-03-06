<?php

declare(strict_types=1);

namespace App\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class AdmissionToValidate implements SerializableReadModel
{
    private string $admissionId;
    private int $itemId;
    private int $userId;

    public function __construct(string $admissionId, int $itemId, int $userId)
    {
        $this->admissionId = $admissionId;
        $this->itemId = $itemId;
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return (string) $this->itemId;
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['admissionId'],
            $data['itemId'],
            $data['userId']
        );
    }

    public function serialize(): array
    {
        return [
            'admissionId' => $this->admissionId,
            'itemId' => $this->itemId,
            'userId' => $this->userId,
        ];
    }
}

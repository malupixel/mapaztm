<?php
declare(strict_types=1);

namespace App\Model;

final class Location
{
    public function __construct(
        private readonly int $latitude,
        private readonly int $longitude,
        private readonly \DateTimeImmutable $createdAt
    )
    {}

    public function getLatitude(): int
    {
        return $this->latitude;
    }
    public function getLongitude(): int
    {
        return $this->longitude;
    }
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
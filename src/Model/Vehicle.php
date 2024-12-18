<?php
declare(strict_types=1);

namespace App\Model;

final class Vehicle
{
    public function __construct(
        private readonly string $line,
        private readonly string $number,
        private readonly string $brigade,
        private readonly Location $location
    ) {}

    public function getLine(): string
    {
        return $this->line;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getBrigade(): string
    {
        return $this->brigade;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
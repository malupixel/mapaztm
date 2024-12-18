<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Model\Vehicle;
use App\Service\Ztm;

final class VehicleRepository extends BaseRepository
{
    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM vehicles');
    }

    public function update(): void
    {
        $vehicles = (new Ztm())->getTramsLocation();
        $this->clear();
        foreach ($vehicles as $vehicle) {
            $this->add($vehicle);
        }
    }

    public function add(Vehicle $vehicle): void
    {
        $this->db->insert(
            sprintf(
                "INSERT INTO vehicles VALUES (%u, '%s', '%s', %u, %u, '%s')",
                (int) $vehicle->getNumber(),
                $vehicle->getLine(),
                $vehicle->getBrigade(),
                $vehicle->getLocation()->getLatitude(),
                $vehicle->getLocation()->getLongitude(),
                $vehicle->getLocation()->getCreatedAt()->format('Y-m-d H:i:s')
            )
        );
    }

    public function clear(): void
    {
        $this->db->query('DELETE FROM vehicles');
    }
}

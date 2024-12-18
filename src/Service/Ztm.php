<?php
declare(strict_types=1);

namespace App\Service;

use App\Enum\VehicleType;

final class Ztm
{
    const API_URL = 'https://api.um.warszawa.pl/api/action/busestrams_get/';
    const API_KEY = 'e13e1562-8602-4138-a8a3-28f6ed854e6b';
    const API_RESOURCE_ID = 'f2e5503e-927d-4ad3-9500-4ab9e55deb59';

    public function getBusesLocation(): array
    {
        $data = $this->get(VehicleType::BUS);

        return VehiclesBuilder::create($data['result']);
    }

    public function getTramsLocation(): array
    {
        $data = $this->get(VehicleType::TRAM);

        return VehiclesBuilder::create($data['result']);
    }

    private function get(VehicleType $type): array
    {
        $data = [
            'resource_id' => self::API_RESOURCE_ID,
            'apikey' => self::API_KEY,
            'type' => $type->value,
        ];

        return json_decode(file_get_contents(self::API_URL . '?' . http_build_query($data)), true);
    }
}

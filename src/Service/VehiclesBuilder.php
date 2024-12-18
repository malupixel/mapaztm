<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Location;
use App\Model\Vehicle;

final class VehiclesBuilder
{
    /**
     * @param array $vehiclesArray
     * @return array|Vehicle[]
     * @throws \DateMalformedStringException
     */
    public static function create(array $vehiclesArray): array
    {
        $result = [];
        $maxTime = (new \DateTimeImmutable())->sub(new \DateInterval('PT10M'));

        foreach ($vehiclesArray as $vehicle) {
            $time = new \DateTimeImmutable($vehicle['Time']);
            if ($time > $maxTime) {
                $result[] = new Vehicle(
                    $vehicle['Lines'],
                    $vehicle['VehicleNumber'],
                    $vehicle['Brigade'],
                    new Location(
                        (int) round($vehicle['Lat'] * 1000000),
                        (int) round($vehicle['Lon'] * 1000000),
                        $time
                    )
                );
            }
        }

        return $result;
    }
}
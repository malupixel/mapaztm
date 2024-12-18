<?php
declare(strict_types=1);

namespace App\Service;

use App\Repositories\InfoRepository;
use App\Repositories\VehicleRepository;

final class VehiclesProvider
{
    public function getVehicles(): array
    {
        $infoRepository = new InfoRepository();
        if ($infoRepository->isLastApiReadOld()) {
            (new VehicleRepository())->update();
            (new InfoRepository())->logLastApiRead();
        }

        return (new VehicleRepository())->getAll();
    }
}

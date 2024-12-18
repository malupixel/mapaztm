<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\VehiclesProvider;

final class AjaxController extends BaseController
{
    public function getVehicles(): void
    {
        print json_encode((new VehiclesProvider())->getVehicles());
    }
}
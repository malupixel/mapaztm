<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\VehiclesProvider;

final class HomeController extends BaseController
{
    public function start(): void
    {
       $this->render(
           template: 'home.php',
           data: [
               'vehicles' => (new VehiclesProvider())->getVehicles(),
           ]
       );
    }
}
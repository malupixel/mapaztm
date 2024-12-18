<?php
header('Content-Type: text/html; charset=utf-8');

use App\Controller\AjaxController;

require __DIR__ . '/vendor/autoload.php';

(new AjaxController())->getVehicles();

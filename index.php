<?php
header('Content-Type: text/html; charset=utf-8');

use App\Controller\HomeController;

require __DIR__ . '/vendor/autoload.php';

(new HomeController())->start();

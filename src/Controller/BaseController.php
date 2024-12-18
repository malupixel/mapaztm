<?php
declare(strict_types=1);

namespace App\Controller;

abstract class BaseController
{
    protected function render(string $template, array $data = []): void {
        extract($data);
        ob_start();
        include __DIR__ . '/../View/' . $template;
        $content = ob_get_clean();
        include __DIR__ . '/../View/layout.php';
    }
}
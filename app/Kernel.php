<?php declare(strict_types = 1);

namespace App;

use Venta\Framework\Kernel\Kernel as FrameworkKernel;

/**
 * Class Kernel
 *
 * @package App
 */
class Kernel extends FrameworkKernel
{
    /**
     * @inheritDoc
     */
    public function getRootPath(): string
    {
        return realpath(__DIR__ . '/../');
    }

}
<?php

use Venta\Framework\Application;
use Venta\Framework\Contracts\ApplicationContract;

/*
|--------------------------------------------------------------------------
| Creating and returning main application class
|--------------------------------------------------------------------------
*/
return new class extends Application {
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->singleton(ApplicationContract::class, $this);
    }
};
<?php

namespace App\Notifications\FlashMessages;

use Illuminate\Support\Facades\Facade;

class LivewireFlash extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lwflash';
    }
}

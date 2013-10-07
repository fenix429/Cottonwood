<?php

namespace Cottonwood\Support\Facades;

use Illuminate\Support\Facades\Facade;

class MessagePublisher extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'MessagePublisher'; }

}
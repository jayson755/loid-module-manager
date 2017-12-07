<?php

namespace Loid\Module\Manager\Support\Facades\Logic;

use Loid\Module\Manager\Logic\User as LogicUser;
use Illuminate\Support\Facades\Facade;

class User extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LogicUser::class;
    }
}
